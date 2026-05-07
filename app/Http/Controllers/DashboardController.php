<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\Inventory;
use App\Models\OutgoingLetter;

class DashboardController extends Controller
{
    public function index()
    {
        $incomingCount = IncomingLetter::query()->count();
        $outgoingCount = OutgoingLetter::query()->count();
        $inventoryCount = Inventory::query()->count();

        $from = now()->subMonths(5)->startOfMonth();

        $incomingGrouped = IncomingLetter::query()
            ->where('tanggal_surat', '>=', $from)
            ->get()
            ->groupBy(fn (IncomingLetter $letter) => $letter->tanggal_surat->format('Y-m'))
            ->map->count();

        $outgoingGrouped = OutgoingLetter::query()
            ->where('tanggal_surat', '>=', $from)
            ->get()
            ->groupBy(fn (OutgoingLetter $letter) => $letter->tanggal_surat->format('Y-m'))
            ->map->count();

        $chartLabels = [];
        $incomingTrend = [];
        $outgoingTrend = [];

        foreach (range(5, 0) as $i) {
            $ym = now()->subMonths($i)->format('Y-m');
            $chartLabels[] = now()->subMonths($i)->format('m/Y');
            $incomingTrend[] = $incomingGrouped[$ym] ?? 0;
            $outgoingTrend[] = $outgoingGrouped[$ym] ?? 0;
        }

        $chartMax = max(array_merge($incomingTrend, $outgoingTrend, [1]));

        return view('dashboard', compact(
            'incomingCount',
            'outgoingCount',
            'inventoryCount',
            'chartLabels',
            'incomingTrend',
            'outgoingTrend',
            'chartMax',
        ));
    }
}
