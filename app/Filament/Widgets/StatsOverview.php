<?php
namespace App\Filament\Widgets;
use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $totalTransaksi    = Transaksi::count();
        $transaksiHariIni  = Transaksi::whereDate('created_at', today())->count();
        $transaksiAktif    = Transaksi::where('status', 'aktif')->count();
        $totalPendapatan   = Transaksi::sum('biaya_total');
        $pendapatanHariIni = Transaksi::whereDate('created_at', today())->sum('biaya_total');
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', now()->month) // [!code ++]
                                        ->whereYear('created_at', now()->year)  // [!code ++]
                                        ->sum('biaya_total');                   // [!code ++]
        return [
            // ── Ringkasan Keuangan ──────────────────────────
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Dari ' . $totalTransaksi . ' transaksi')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($pendapatanHariIni, 0, ',', '.'))
                ->description(today()->translatedFormat('d F Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($pendapatanBulanIni, 0, ',', '.')) // [!code ++]
                ->description(now()->translatedFormat('F Y'))                                            // [!code ++]
                ->descriptionIcon('heroicon-m-chart-bar')                                               // [!code ++]
                ->color('info'),                                                                         // [!code ++]
            // ── Status Operasional ──────────────────────────
            Stat::make('Total Transaksi', Transaksi::count())
                ->description('Semua transaksi')
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('primary'),
            Stat::make('Transaksi Hari Ini', $transaksiHariIni)
                ->description('Transaksi hari ini')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),
            Stat::make('Transaksi Aktif', $transaksiAktif)
                ->description('Kendaraan masih parkir')
                ->descriptionIcon('heroicon-m-truck')
                ->color('warning'),
        ];
    }
}