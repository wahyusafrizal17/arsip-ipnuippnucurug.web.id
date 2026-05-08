<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\IncomingLetter;
use App\Models\Inventory;
use App\Models\JointLetter;
use App\Models\OutgoingLetter;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $jointCount = JointLetter::query()->count();
        $inventoryCount = Inventory::query()->count();

        $from = now()->subMonths(5)->startOfMonth();

        if ($user->role === UserRole::Admin) {
            $incomingIpnu = IncomingLetter::query()->where('organization', 'ipnu')->count();
            $incomingIppnu = IncomingLetter::query()->where('organization', 'ippnu')->count();
            $incomingIpnuIppnu = IncomingLetter::query()->where('organization', 'ipnu_ippnu')->count();
            $outgoingIpnu = OutgoingLetter::query()->where('organization', 'ipnu')->count();
            $outgoingIppnu = OutgoingLetter::query()->where('organization', 'ippnu')->count();
            $outgoingIpnuIppnu = OutgoingLetter::query()->where('organization', 'ipnu_ippnu')->count();

            $incomingQuery = IncomingLetter::query()->where('tanggal_surat', '>=', $from);
            $outgoingQuery = OutgoingLetter::query()->where('tanggal_surat', '>=', $from);
        } else {
            $org = $user->role->letterOrganization();
            $incomingIpnu = null;
            $incomingIppnu = null;
            $incomingIpnuIppnu = null;
            $outgoingIpnu = null;
            $outgoingIppnu = null;
            $outgoingIpnuIppnu = null;

            $orgFilter = $org === 'ipnu' ? ['ipnu', 'ipnu_ippnu'] : ['ippnu', 'ipnu_ippnu'];

            $incomingCount = IncomingLetter::query()->whereIn('organization', $orgFilter)->count();
            $outgoingCount = OutgoingLetter::query()->whereIn('organization', $orgFilter)->count();

            $incomingQuery = IncomingLetter::query()
                ->whereIn('organization', $orgFilter)
                ->where('tanggal_surat', '>=', $from);
            $outgoingQuery = OutgoingLetter::query()
                ->whereIn('organization', $orgFilter)
                ->where('tanggal_surat', '>=', $from);
        }

        $incomingGrouped = $incomingQuery
            ->get()
            ->groupBy(fn (IncomingLetter $letter) => $letter->tanggal_surat->format('Y-m'))
            ->map->count();

        $outgoingGrouped = $outgoingQuery
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

        if ($user->role === UserRole::Admin) {
            return view('dashboard', compact(
                'user',
                'incomingIpnu',
                'incomingIppnu',
                'incomingIpnuIppnu',
                'outgoingIpnu',
                'outgoingIppnu',
                'outgoingIpnuIppnu',
                'jointCount',
                'inventoryCount',
                'chartLabels',
                'incomingTrend',
                'outgoingTrend',
                'chartMax',
            ));
        }

        return view('dashboard', compact(
            'user',
            'incomingCount',
            'outgoingCount',
            'jointCount',
            'inventoryCount',
            'chartLabels',
            'incomingTrend',
            'outgoingTrend',
            'chartMax',
        ));
    }
}
