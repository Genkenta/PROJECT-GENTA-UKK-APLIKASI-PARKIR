<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class TransaksiChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Transaksi';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'mingguan';

    protected function getFilters(): ?array
    {
        return [
            'mingguan' => 'Mingguan',
            'harian'   => 'Per Jam (Hari Ini)',
            'bulanan'  => 'Bulanan',
        ];
    }

    protected function getData(): array
    {
        return match ($this->filter ?? 'mingguan') {
            'harian'  => $this->getDataHarian(),
            'bulanan' => $this->getDataBulanan(),
            default   => $this->getDataMingguan(),
        };
    }

    protected function getDataMingguan(): array
    {
        $labels     = [];
        $counts     = [];
        $pendapatan = [];

        for ($i = 6; $i >= 0; $i--) {
            $date         = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[]     = Carbon::now()->subDays($i)->format('d/m');
            $counts[]     = Transaksi::whereDate('created_at', $date)->count();
            $pendapatan[] = Transaksi::whereDate('created_at', $date)->sum('biaya_total');
        }

        return [
            'datasets' => [
                [
                    'label'                => 'Jumlah Transaksi',
                    'data'                 => $counts,
                    'borderColor'          => '#f0a500',
                    'backgroundColor'      => 'rgba(240, 165, 0, 0.15)',
                    'pointBackgroundColor' => '#f0a500',
                    'pointRadius'          => 4,
                    'pointHoverRadius'     => 6,
                    'fill'                 => true,
                    'tension'              => 0.4,
                    'yAxisID'              => 'y',
                ],
                [
                    'label'                => 'Pendapatan (Rp)',
                    'data'                 => $pendapatan,
                    'borderColor'          => '#60a5fa',
                    'backgroundColor'      => 'rgba(96, 165, 250, 0.15)',
                    'pointBackgroundColor' => '#60a5fa',
                    'pointRadius'          => 4,
                    'pointHoverRadius'     => 6,
                    'fill'                 => true,
                    'tension'              => 0.4,
                    'yAxisID'              => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getDataHarian(): array
    {
        $labels     = [];
        $pendapatan = [];

        for ($h = 0; $h < 24; $h++) {
            $labels[] = sprintf('%02d:00', $h);

            // ✅ Gunakan whereRaw dengan HOUR() agar MySQL membaca dengan benar
            $pendapatan[] = Transaksi::whereDate('created_at', today())
                ->whereNotNull('waktu_keluar')
                ->whereRaw('HOUR(waktu_keluar) = ?', [$h])
                ->sum('biaya_total');
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Pendapatan per Jam (Rp)',
                    'data'            => $pendapatan,
                    'backgroundColor' => 'rgba(240, 165, 0, 0.3)',
                    'borderColor'     => '#f0a500',
                    'borderWidth'     => 1.5,
                    'borderRadius'    => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getDataBulanan(): array
    {
        $labels     = [];
        $counts     = [];
        $pendapatan = [];

        for ($i = 11; $i >= 0; $i--) {
            $month        = Carbon::now()->subMonths($i);
            $labels[]     = $month->format('M Y');
            $counts[]     = Transaksi::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $pendapatan[] = Transaksi::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('biaya_total');
        }

        return [
            'datasets' => [
                [
                    'label'                => 'Jumlah Transaksi',
                    'data'                 => $counts,
                    'borderColor'          => '#f0a500',
                    'backgroundColor'      => 'rgba(240, 165, 0, 0.15)',
                    'pointBackgroundColor' => '#f0a500',
                    'pointRadius'          => 4,
                    'pointHoverRadius'     => 6,
                    'fill'                 => true,
                    'tension'              => 0.4,
                    'yAxisID'              => 'y',
                ],
                [
                    'label'                => 'Pendapatan (Rp)',
                    'data'                 => $pendapatan,
                    'borderColor'          => '#4ade80',
                    'backgroundColor'      => 'rgba(74, 222, 128, 0.15)',
                    'pointBackgroundColor' => '#4ade80',
                    'pointRadius'          => 4,
                    'pointHoverRadius'     => 6,
                    'fill'                 => true,
                    'tension'              => 0.4,
                    'yAxisID'              => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return ($this->filter ?? 'mingguan') === 'harian' ? 'bar' : 'line';
    }

    protected function getOptions(): array
    {
        $isBulanan = ($this->filter ?? 'mingguan') === 'bulanan';
        $isHarian  = ($this->filter ?? 'mingguan') === 'harian';

        if ($isHarian) {
            return [
                'responsive'  => true,
                'interaction' => ['mode' => 'index', 'intersect' => false],
                'plugins'     => [
                    'legend' => [
                        'display'  => true,
                        'position' => 'top',
                        'labels'   => [
                            'usePointStyle' => true,
                            'pointStyle'    => 'rectRounded',
                            'padding'       => 16,
                            'color'         => '#9ca3af',
                        ],
                    ],
                ],
                'scales' => [
                    'x' => [
                        'grid'  => ['display' => false],
                        'ticks' => ['color' => '#6b7280'],
                    ],
                    'y' => [
                        'beginAtZero' => true,
                        'grid'        => ['color' => 'rgba(107,114,128,0.15)'],
                        'ticks'       => ['color' => '#f0a500'],
                    ],
                ],
            ];
        }

        return [
            'responsive'  => true,
            'interaction' => ['mode' => 'index', 'intersect' => false],
            'plugins'     => [
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                    'labels'   => [
                        'usePointStyle' => true,
                        'pointStyle'    => 'circle',
                        'padding'       => 20,
                        'color'         => '#9ca3af',
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(17,24,39,0.9)',
                    'titleColor'      => '#f9fafb',
                    'bodyColor'       => '#d1d5db',
                    'borderColor'     => 'rgba(255,255,255,0.1)',
                    'borderWidth'     => 1,
                    'padding'         => 10,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid'  => ['display' => false],
                    'ticks' => ['color' => '#6b7280'],
                ],
                'y' => [
                    'type'        => 'linear',
                    'position'    => 'left',
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(107,114,128,0.15)'],
                    'ticks'       => ['color' => '#f0a500', 'precision' => 0],
                    'title'       => [
                        'display' => true,
                        'text'    => 'Jumlah Transaksi',
                        'color'   => '#f0a500',
                    ],
                ],
                'y1' => [
                    'type'        => 'linear',
                    'position'    => 'right',
                    'beginAtZero' => true,
                    'grid'        => ['drawOnChartArea' => false],
                    'ticks'       => ['color' => $isBulanan ? '#4ade80' : '#60a5fa'],
                    'title'       => [
                        'display' => true,
                        'text'    => 'Pendapatan (Rp)',
                        'color'   => $isBulanan ? '#4ade80' : '#60a5fa',
                    ],
                ],
            ],
        ];
    }
}