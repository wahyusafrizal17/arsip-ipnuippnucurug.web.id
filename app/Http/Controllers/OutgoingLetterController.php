<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutgoingLetterRequest;
use App\Http\Requests\UpdateOutgoingLetterRequest;
use App\Models\OutgoingLetter;
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
        [$sort, $direction] = $this->resolvedSort($request);

        $letters = OutgoingLetter::query()
            ->search($request->query('q'))
            ->tanggalBetween($request->query('date_from'), $request->query('date_to'))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('outgoing-letters.index', compact('letters', 'sort', 'direction'));
    }

    public function create()
    {
        return view('outgoing-letters.create');
    }

    public function store(StoreOutgoingLetterRequest $request)
    {
        $validated = $request->validated();
        unset($validated['file_dokumen']);
        $validated['file_path'] = $request->file('file_dokumen')->store('outgoing_letters', 'public_web');

        OutgoingLetter::query()->create($validated);

        return redirect()->route('outgoing-letters.index')->with('success', 'Surat keluar berhasil disimpan.');
    }

    public function show(OutgoingLetter $outgoingLetter)
    {
        return view('outgoing-letters.show', compact('outgoingLetter'));
    }

    public function edit(OutgoingLetter $outgoingLetter)
    {
        return view('outgoing-letters.edit', compact('outgoingLetter'));
    }

    public function update(UpdateOutgoingLetterRequest $request, OutgoingLetter $outgoingLetter)
    {
        $validated = $request->validated();
        unset($validated['file_dokumen']);

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
        if ($outgoingLetter->file_path) {
            Storage::disk('public_web')->delete($outgoingLetter->file_path);
        }

        $outgoingLetter->delete();

        return redirect()->route('outgoing-letters.index')->with('success', 'Surat keluar dihapus.');
    }

    public function download(OutgoingLetter $outgoingLetter)
    {
        if (! $outgoingLetter->file_path || ! Storage::disk('public_web')->exists($outgoingLetter->file_path)) {
            abort(404);
        }

        return Storage::disk('public_web')->download($outgoingLetter->file_path);
    }
}
