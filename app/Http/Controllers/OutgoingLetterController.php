<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutgoingLetterRequest;
use App\Http\Requests\UpdateOutgoingLetterRequest;
use App\Models\OutgoingLetter;
use App\Support\OrganizationAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutgoingLetterController extends Controller
{
    /**
     * @return array{0: string, 1: string}
     */
    private function resolvedSort(Request $request): array
    {
        $sort = $request->query('sort', 'tanggal_surat');
        $direction = $request->query('direction', 'desc');
        if (! in_array($sort, ['tanggal_surat', 'tanggal_pengiriman', 'indeks', 'created_at'], true)) {
            $sort = 'tanggal_surat';
        }
        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        return [$sort, $direction];
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', OutgoingLetter::class);

        [$sort, $direction] = $this->resolvedSort($request);

        $letters = OutgoingLetter::query()
            ->tap(fn ($q) => OrganizationAccess::scopeOutgoingForUser($q, $request))
            ->search($request->query('q'))
            ->tanggalBetween($request->query('date_from'), $request->query('date_to'))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        $pageSubtitle = $this->pageSubtitle($request);

        return view('outgoing-letters.index', compact('letters', 'sort', 'direction', 'pageSubtitle'));
    }

    private function pageSubtitle(Request $request): string
    {
        $user = $request->user();
        if ($user->isAdmin()) {
            $o = $request->query('organization');
            if ($o === 'ipnu') {
                return 'Arsip surat keluar organisasi IPNU.';
            }
            if ($o === 'ippnu') {
                return 'Arsip surat keluar organisasi IPPNU.';
            }
            if ($o === 'ipnu_ippnu') {
                return 'Arsip surat keluar organisasi IPNU IPPNU.';
            }

            return 'Semua surat keluar IPNU & IPPNU.';
        }

        return match ($user->role->letterOrganization()) {
            'ipnu' => 'Arsip surat keluar administrasi IPNU.',
            'ippnu' => 'Arsip surat keluar administrasi IPPNU.',
            default => 'Arsip surat keluar.',
        };
    }

    public function create(Request $request)
    {
        $this->authorize('create', OutgoingLetter::class);

        $allowed = array_keys(config('archive.letter_organizations', []));
        $defaultOrg = $request->query('organization');
        if (! in_array($defaultOrg, $allowed, true)) {
            $fallback = $request->user()->role->letterOrganization();
            $defaultOrg = in_array($fallback, $allowed, true) ? $fallback : 'ipnu';
        }

        return view('outgoing-letters.create', compact('defaultOrg'));
    }

    public function store(StoreOutgoingLetterRequest $request)
    {
        $this->authorize('create', OutgoingLetter::class);

        $validated = $request->validated();
        unset($validated['file_dokumen']);
        $validated['organization'] = OrganizationAccess::resolveLetterOrganizationForUser(
            $request->user(),
            $validated['organization'] ?? null
        );
        $validated['file_path'] = $request->file('file_dokumen')->store('outgoing_letters', 'public_web');

        OutgoingLetter::query()->create($validated);

        $indexParams = ['organization' => $validated['organization']];
        if (! $request->user()->isAdmin()) {
            $indexParams = [];
        }

        return redirect()->route('outgoing-letters.index', $indexParams)->with('success', 'Surat keluar berhasil disimpan.');
    }

    public function show(OutgoingLetter $outgoingLetter)
    {
        $this->authorize('view', $outgoingLetter);

        return view('outgoing-letters.show', compact('outgoingLetter'));
    }

    public function edit(OutgoingLetter $outgoingLetter)
    {
        $this->authorize('update', $outgoingLetter);

        return view('outgoing-letters.edit', compact('outgoingLetter'));
    }

    public function update(UpdateOutgoingLetterRequest $request, OutgoingLetter $outgoingLetter)
    {
        $this->authorize('update', $outgoingLetter);

        $validated = $request->validated();
        unset($validated['file_dokumen']);
        $validated['organization'] = OrganizationAccess::resolveLetterOrganizationForUser(
            $request->user(),
            $validated['organization'] ?? null
        );

        if ($request->hasFile('file_dokumen')) {
            if ($outgoingLetter->file_path) {
                Storage::disk('public_web')->delete($outgoingLetter->file_path);
            }
            $validated['file_path'] = $request->file('file_dokumen')->store('outgoing_letters', 'public_web');
        }

        $outgoingLetter->update($validated);

        return redirect()->route('outgoing-letters.show', $outgoingLetter)->with('success', 'Surat keluar diperbarui.');
    }

    public function destroy(OutgoingLetter $outgoingLetter)
    {
        $this->authorize('delete', $outgoingLetter);

        if ($outgoingLetter->file_path) {
            Storage::disk('public_web')->delete($outgoingLetter->file_path);
        }

        $outgoingLetter->delete();

        return redirect()->route('outgoing-letters.index')->with('success', 'Surat keluar dihapus.');
    }

    public function download(OutgoingLetter $outgoingLetter)
    {
        $this->authorize('view', $outgoingLetter);

        if (! $outgoingLetter->file_path || ! Storage::disk('public_web')->exists($outgoingLetter->file_path)) {
            abort(404);
        }

        return Storage::disk('public_web')->download($outgoingLetter->file_path);
    }
}
