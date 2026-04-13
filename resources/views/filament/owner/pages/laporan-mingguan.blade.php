<x-filament-panels::page>

    {{-- FORM FILTER --}}
    <x-filament::section heading="Filter Periode">
        <form wire:submit="tampilkan">
            {{ $this->form }}
            <div class="flex flex-wrap gap-2 mt-4">
                <x-filament::button type="button" color="gray" wire:click="setBulanIni">
                    Bulan Ini
                </x-filament::button>
                <x-filament::button type="submit" icon="heroicon-m-magnifying-glass">
                    Tampilkan
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    {{-- SUMMARY CARDS --}}
    @php
        $summary      = $this->getSummary();
        $chart        = $this->getChartData();
        $periodeLabel = $this->getPeriodeLabel();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-filament::section>
            <p class="text-sm text-gray-400">Total Hari Aktif</p>
            <p class="text-3xl font-bold text-primary-400 mt-1">
                {{ $summary->total_hari ?? 0 }} Hari
            </p>
        </x-filament::section>

        <x-filament::section>
            <p class="text-sm text-gray-400">Total Kendaraan</p>
            <p class="text-3xl font-bold text-info-400 mt-1">
                {{ number_format($summary->total_transaksi ?? 0) }}
            </p>
        </x-filament::section>

        <x-filament::section>
            <p class="text-sm text-gray-400">Total Pendapatan</p>
            <p class="text-3xl font-bold text-success-400 mt-1">
                Rp {{ number_format($summary->total_pendapatan ?? 0) }}
            </p>
        </x-filament::section>
    </div>

    {{-- GRAFIK --}}
    <x-filament::section>
        <x-slot name="heading">
            Grafik Transaksi — {{ $periodeLabel }}
        </x-slot>

        <x-slot name="headerEnd">
            <div class="flex items-center gap-4">
                @foreach(['Minggu 1' => '#f59e0b', 'Minggu 2' => '#60a5fa', 'Minggu 3' => '#4ade80', 'Minggu 4' => '#c084fc'] as $lbl => $clr)
                    <span class="flex items-center gap-1.5 text-xs text-gray-400">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:{{ $clr }}"></span>
                        {{ $lbl }}
                    </span>
                @endforeach
            </div>
        </x-slot>

        <div style="position:relative;width:100%;height:320px">
            <canvas id="chartTransaksi"
                role="img"
                aria-label="Grafik transaksi per minggu">
            </canvas>
        </div>

        @if (empty($chart['labels']))
            <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                <p class="text-sm">Belum ada data</p>
                <p class="text-xs mt-1">Pilih periode dan klik Tampilkan</p>
            </div>
        @endif

    </x-filament::section>

    @assets
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    @endassets

   @script
<script>
(function () {
    const D = {
        labels:     @json($chart['labels'] ?? []),
        transaksi:  @json($chart['transaksi'] ?? []),
        pendapatan: @json($chart['pendapatan'] ?? []),
    };

    const MINGGU_COLORS = ['#f59e0b', '#60a5fa', '#4ade80', '#c084fc'];

    function draw() {
        const dark    = document.documentElement.classList.contains('dark');
        const gridClr = dark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.05)';
        const tickClr = dark ? '#9ca3af' : '#6b7280';

        const ex = Chart.getChart('chartTransaksi');
        if (ex) ex.destroy();

        if (!D.labels.length) return;

        const tooltipStyle = {
            backgroundColor: dark ? 'rgba(17,24,39,0.95)' : 'rgba(255,255,255,0.95)',
            titleColor:      dark ? '#f9fafb'              : '#111827',
            bodyColor:       dark ? '#d1d5db'              : '#374151',
            borderColor:     dark ? 'rgba(255,255,255,0.1)': 'rgba(0,0,0,0.08)',
            borderWidth: 1,
            padding: 10,
            usePointStyle: true,
        };

        new Chart(document.getElementById('chartTransaksi'), {
            type: 'line',
            data: {
                labels: D.labels,
                datasets: [
                    {
                        label: 'Jumlah Kendaraan',
                        data: D.transaksi,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(240,165,0,0.10)',
                        pointBackgroundColor: MINGGU_COLORS,
                        pointBorderColor:     MINGGU_COLORS,
                        pointRadius: 7,
                        pointHoverRadius: 9,
                        borderWidth: 2,
                        fill: true,
                        tension: 0,
                        yAxisID: 'yKendaraan',
                    },
                    {
                        label: 'Pendapatan (Rp)',
                        data: D.pendapatan,
                        borderColor: '#60a5fa',
                        backgroundColor: 'rgba(96,165,250,0.08)',
                        pointBackgroundColor: MINGGU_COLORS,
                        pointBorderColor:     MINGGU_COLORS,
                        pointRadius: 7,
                        pointHoverRadius: 9,
                        borderWidth: 2,
                        fill: false,
                        tension: 0,
                        yAxisID: 'yPendapatan',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 500, easing: 'easeOutQuart' },
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: tickClr,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12 },
                        },
                    },
                    tooltip: {
                        ...tooltipStyle,
                        callbacks: {
                            label: ctx => {
                                if (ctx.dataset.yAxisID === 'yKendaraan') {
                                    return '  ' + ctx.parsed.y + ' kendaraan';
                                }
                                return '  Rp ' + Math.round(ctx.parsed.y).toLocaleString('id-ID');
                            }
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: { color: tickClr, font: { size: 12 } },
                        grid:  { color: gridClr },
                    },
                    yKendaraan: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        ticks: {
                            color: '#f59e0b',
                            font: { size: 11 },
                            callback: v => v % 1 === 0 ? v : '',
                        },
                        grid: { color: gridClr },
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi',
                            color: '#f59e0b',
                            font: { size: 11 },
                        },
                    },
                    yPendapatan: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        ticks: {
                            color: '#60a5fa',
                            font: { size: 11 },
                            callback: v => v >= 1e6 ? 'Rp '+(v/1e6).toFixed(1)+'jt'
                                         : v >= 1e3 ? 'Rp '+(v/1e3).toFixed(0)+'rb'
                                         : 'Rp '+v,
                        },
                        grid: { drawOnChartArea: false },
                        title: {
                            display: true,
                            text: 'Pendapatan (Rp)',
                            color: '#60a5fa',
                            font: { size: 11 },
                        },
                    },
                },
            },
        });
    }

    draw();
    $wire.on('chart-update', () => setTimeout(draw, 80));
})();
</script>
@endscript

</x-filament-panels::page>