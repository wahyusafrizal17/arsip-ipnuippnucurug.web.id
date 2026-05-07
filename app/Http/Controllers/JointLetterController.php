<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJointLetterRequest;
use App\Http\Requests\UpdateJointLetterRequest;
use App\Models\JointLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JointLetterController extends Controller
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
        $this->authorize('viewAny', JointLetter::class);

        [$sort, $direction] = $this->resolvedSort($request);

        $letters = JointLetter::query()
            ->search($request->query('q'))
            ->tanggalBetween($request->query('date_from'), $request->query('date_to'))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('joint-letters.index', compact('letters', 'sort', 'direction'));
    }

    public function create()
    {
        $this->authorize('create', JointLetter::class);

        return view('joint-letters.create');
    }

    public function store(StoreJointLetterRequest $request)
    {
        $this->authorize('create', JointLetter::class);

        $validated = $request->validated();
        unset($validated['file_dokumen']);
        $validated['file_path'] = $request->file('file_dokumen')->store('joint_letters', 'public_web');

        JointLetter::query()->create($validated);

        return redirect()->route('joint-letters.index')->with('success', 'Surat bersama berhasil disimpan.');
    }

    public function show(JointLetter $jointLetter)
    {
        $this->authorize('view', $jointLetter);

        return view('joint-letters.show', compact('jointLetter'));
    }

    public function edit(JointLetter $jointLetter)
    {
        $this->authorize('update', $jointLetter);

        return view('joint-letters.edit', compact('jointLetter'));
    }

    public function update(UpdateJointLetterRequest $request, JointLetter $jointLetter)
    {
        $this->authorize('update', $jointLetter);

        $validated = $request->validated();
        unset($validated['file_dokumen']);

        if ($request->hasFile('file_dokumen')) {
            if ($jointLetter->file_path) {
                Storage::disk('public_web')->delete($jointLetter->file_path);
            }
            $validated['file_path'] = $request->file('file_dokumen')->store('joint_letters', 'public_web');
        }

        $jointLetter->update($validated);

        return redirect()->route('joint-letters.show', $jointLetter)->with('success', 'Surat bersama diperbarui.');
    }

    public function destroy(JointLetter $jointLetter)
    {
        $this->authorize('delete', $jointLetter);

        if ($jointLetter->file_path) {
            Storage::disk('public_web')->delete($jointLetter->file_path);
        }

        $jointLetter->delete();

        return redirect()->route('joint-letters.index')->with('success', 'Surat bersama dihapus.');
    }

    public function download(JointLetter $jointLetter)
    {
        $this->authorize('view', $jointLetter);

        if (! $jointLetter->file_path || ! Storage::disk('public_web')->exists($jointLetter->file_path)) {
            abort(404);
        }

        return Storage::disk('public_web')->download($jointLetter->file_path);
    }
}
