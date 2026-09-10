<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $rekapSumber = collect(Guest::SUMBER)
            ->mapWithKeys(fn (string $sumber) => [
                $sumber => Guest::query()->where('sumber', $sumber)->count(),
            ]);

        return view('admin.dashboard', [
            'tamuBulanIni' => Guest::query()->padaBulan()->count(),
            'totalTamu' => Guest::query()->count(),
            'rekapSumber' => $rekapSumber,
            'kunjunganTerbaru' => Guest::query()
                ->latest('tanggal_kunjungan')
                ->latest('created_at')
                ->limit(5)
                ->get(),
        ]);
    }
}
