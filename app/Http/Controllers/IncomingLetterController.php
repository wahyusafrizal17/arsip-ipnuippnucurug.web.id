<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomingLetterRequest;
use App\Http\Requests\UpdateIncomingLetterRequest;
use App\Models\IncomingLetter;
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
        [$sort, $direction] = $this->resolvedSort($request);

        $letters = IncomingLetter::query()
            ->search($request->query('q'))
            ->tanggalBetween($request->query('date_from'), $request->query('date_to'))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('incoming-letters.index', compact('letters', 'sort', 'direction'));
    }

    public function create()
    {
        return view('incoming-letters.create');
    }

    public function store(StoreIncomingLetterRequest $request)
    {
        $validated = $request->validated();
        unset($validated['file_dokumen']);
        $validated['file_path'] = $request->file('file_dokumen')->store('incoming_letters', 'public_web');

        IncomingLetter::query()->create($validated);

        return redirect()->route('incoming-letters.index')->with('success', 'Surat masuk berhasil disimpan.');
    }

    public function show(IncomingLetter $incomingLetter)
    {
        return view('incoming-letters.show', compact('incomingLetter'));
    }

    public function edit(IncomingLetter $incomingLetter)
    {
        return view('incoming-letters.edit', compact('incomingLetter'));
    }

    public function update(UpdateIncomingLetterRequest $request, IncomingLetter $incomingLetter)
    {
        $validated = $request->validated();
        unset($validated['file_dokumen']);

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
        if ($incomingLetter->file_path) {
            Storage::disk('public_web')->delete($incomingLetter->file_path);
        }

        $incomingLetter->delete();

        return redirect()->route('incoming-letters.index')->with('success', 'Surat masuk dihapus.');
    }

    public function download(IncomingLetter $incomingLetter)
    {
        if (! $incomingLetter->file_path || ! Storage::disk('public_web')->exists($incomingLetter->file_path)) {
            abort(404);
        }

        return Storage::disk('public_web')->download($incomingLetter->file_path);
    }
}
