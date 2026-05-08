<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomingLetterRequest;
use App\Http\Requests\UpdateIncomingLetterRequest;
use App\Models\IncomingLetter;
use App\Support\OrganizationAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomingLetterController extends Controller
{
    /**
     * @return array{0: string, 1: string}
     */
    private function resolvedSort(Request $request): array
    {
        $sort = $request->query('sort', 'tanggal_surat');
        $direction = $request->query('direction', 'desc');
        if (! in_array($sort, ['tanggal_surat', 'indeks', 'created_at'], true)) {
            $sort = 'tanggal_surat';
        }
        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        return [$sort, $direction];
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', IncomingLetter::class);

        [$sort, $direction] = $this->resolvedSort($request);

        $letters = IncomingLetter::query()
            ->tap(fn ($q) => OrganizationAccess::scopeIncomingForUser($q, $request))
            ->search($request->query('q'))
            ->tanggalBetween($request->query('date_from'), $request->query('date_to'))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        $pageSubtitle = $this->pageSubtitle($request);

        return view('incoming-letters.index', compact('letters', 'sort', 'direction', 'pageSubtitle'));
    }

    private function pageSubtitle(Request $request): string
    {
        $user = $request->user();
        if ($user->isAdmin()) {
            $o = $request->query('organization');
            if ($o === 'ipnu') {
                return 'Arsip surat masuk organisasi IPNU.';
            }
            if ($o === 'ippnu') {
                return 'Arsip surat masuk organisasi IPPNU.';
            }
            if ($o === 'ipnu_ippnu') {
                return 'Arsip surat masuk organisasi IPNU IPPNU.';
            }

            return 'Semua surat masuk IPNU & IPPNU.';
        }

        return match ($user->role->letterOrganization()) {
            'ipnu' => 'Arsip surat masuk administrasi IPNU.',
            'ippnu' => 'Arsip surat masuk administrasi IPPNU.',
            default => 'Arsip surat masuk.',
        };
    }

    public function create(Request $request)
    {
        $this->authorize('create', IncomingLetter::class);

        $allowed = array_keys(config('archive.letter_organizations', []));
        $defaultOrg = $request->query('organization');
        if (! in_array($defaultOrg, $allowed, true)) {
            $fallback = $request->user()->role->letterOrganization();
            $defaultOrg = in_array($fallback, $allowed, true) ? $fallback : 'ipnu';
        }

        return view('incoming-letters.create', compact('defaultOrg'));
    }

    public function store(StoreIncomingLetterRequest $request)
    {
        $this->authorize('create', IncomingLetter::class);

        $validated = $request->validated();
        unset($validated['file_dokumen']);
        $validated['organization'] = OrganizationAccess::resolveLetterOrganizationForUser(
            $request->user(),
            $validated['organization'] ?? null
        );
        $validated['file_path'] = $request->file('file_dokumen')->store('incoming_letters', 'public_web');

        IncomingLetter::query()->create($validated);

        $indexParams = ['organization' => $validated['organization']];
        if (! $request->user()->isAdmin()) {
            $indexParams = [];
        }

        return redirect()->route('incoming-letters.index', $indexParams)->with('success', 'Surat masuk berhasil disimpan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        $this->authorize('view', $incomingLetter);

        return view('incoming-letters.show', compact('incomingLetter'));
    }

    public function edit(IncomingLetter $incomingLetter)
    {
        $this->authorize('update', $incomingLetter);

        return view('incoming-letters.edit', compact('incomingLetter'));
    }

    public function update(UpdateIncomingLetterRequest $request, IncomingLetter $incomingLetter)
    {
        $this->authorize('update', $incomingLetter);

        $validated = $request->validated();
        unset($validated['file_dokumen']);
        $validated['organization'] = OrganizationAccess::resolveLetterOrganizationForUser(
            $request->user(),
            $validated['organization'] ?? null
        );

        if ($request->hasFile('file_dokumen')) {
            if ($incomingLetter->file_path) {
                Storage::disk('public_web')->delete($incomingLetter->file_path);
            }
            $validated['file_path'] = $request->file('file_dokumen')->store('incoming_letters', 'public_web');
        }

        $incomingLetter->update($validated);

        return redirect()->route('incoming-letters.show', $incomingLetter)->with('success', 'Surat masuk diperbarui.');
    }

    public function destroy(IncomingLetter $incomingLetter)
    {
        $this->authorize('delete', $incomingLetter);

        if ($incomingLetter->file_path) {
            Storage::disk('public_web')->delete($incomingLetter->file_path);
        }

        $incomingLetter->delete();

        return redirect()->route('incoming-letters.index')->with('success', 'Surat masuk dihapus.');
    }

    public function download(IncomingLetter $incomingLetter)
    {
        $this->authorize('view', $incomingLetter);

        if (! $incomingLetter->file_path || ! Storage::disk('public_web')->exists($incomingLetter->file_path)) {
            abort(404);
        }

        return Storage::disk('public_web')->download($incomingLetter->file_path);
    }
}
