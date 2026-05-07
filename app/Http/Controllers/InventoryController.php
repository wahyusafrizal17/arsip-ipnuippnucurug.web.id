<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * @return array{0: string, 1: string}
     */
    private function resolvedSort(Request $request): array
    {
        $sort = $request->query('sort', 'nama_barang');
        $direction = $request->query('direction', 'asc');
        if (! in_array($sort, ['nama_barang', 'jumlah', 'status_barang', 'created_at'], true)) {
            $sort = 'nama_barang';
        }
        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        return [$sort, $direction];
    }

    public function index(Request $request)
    {
        [$sort, $direction] = $this->resolvedSort($request);

        $items = Inventory::query()
            ->search($request->query('q'))
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('inventories.index', compact('items', 'sort', 'direction'));
    }

    public function create()
    {
        return view('inventories.create');
    }

    public function store(StoreInventoryRequest $request)
    {
        Inventory::query()->create($request->validated());

        return redirect()->route('inventories.index')->with('success', 'Item inventaris berhasil ditambahkan.');
    }

    public function edit(Inventory $inventory)
    {
        return view('inventories.edit', compact('inventory'));
    }

    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        $inventory->update($request->validated());

        return redirect()->route('inventories.index')->with('success', 'Item inventaris diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Item inventaris dihapus.');
    }
}
