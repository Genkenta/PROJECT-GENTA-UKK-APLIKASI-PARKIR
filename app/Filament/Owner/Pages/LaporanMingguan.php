<?php

namespace App\Filament\Owner\Pages;

use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use BackedEnum;
use UnitEnum;

class LaporanMingguan extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;
    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Laporan Mingguan';
    protected static ?string $title = 'Laporan Mingguan';
    protected static ?int $navigationSort = 3;
    protected string $view = 'filament.owner.pages.laporan-mingguan';

    public ?array $data = [];
    public string $mode = 'bulanan';
    public string $bulan = '';
    public string $tahun = '';
    public string $tanggal_mulai = '';
    public string $tanggal_selesai = '';

    public function mount(): void
    {
        $this->mode            = 'bulanan';
        $this->bulan           = Carbon::now()->format('m');
        $this->tahun           = Carbon::now()->format('Y');
        $this->tanggal_mulai   = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = Carbon::now()->endOfMonth()->format('Y-m-d');

        $this->form->fill([
            'mode'            => $this->mode,
            'bulan'           => $this->bulan,
            'tahun'           => $this->tahun,
            'tanggal_mulai'   => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('mode')
                    ->label('Tampilkan Per')
                    ->options([
                        'bulanan'  => 'Per Minggu (Bulanan)',
                        'rentang'  => 'Rentang Tanggal',
                    ])
                    ->required()
                    ->live(),

                Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '01' => 'Januari',  '02' => 'Februari', '03' => 'Maret',
                        '04' => 'April',    '05' => 'Mei',       '06' => 'Juni',
                        '07' => 'Juli',     '08' => 'Agustus',   '09' => 'September',
                        '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember',
                    ])
                    ->visible(fn ($get) => $get('mode') === 'bulanan'),

                Select::make('tahun')
                    ->label('Tahun')
                    ->options(collect(range(Carbon::now()->year, Carbon::now()->year - 4))
                        ->mapWithKeys(fn ($y) => [$y => (string) $y])
                        ->toArray())
                    ->visible(fn ($get) => $get('mode') === 'bulanan'),

                DatePicker::make('tanggal_mulai')
                    ->label('Tanggal Awal')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->visible(fn ($get) => $get('mode') === 'rentang'),

                DatePicker::make('tanggal_selesai')
                    ->label('Tanggal Akhir')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->afterOrEqual('tanggal_mulai')
                    ->visible(fn ($get) => $get('mode') === 'rentang'),
            ])
            ->columns(4)
            ->statePath('data');
    }

    public function tampilkan(): void
    {
        $validated = $this->form->getState();

        $this->mode = $validated['mode'] ?? 'bulanan';

        if ($this->mode === 'bulanan') {
            $this->bulan = $validated['bulan'] ?? Carbon::now()->format('m');
            $this->tahun = $validated['tahun'] ?? Carbon::now()->format('Y');
            $this->data['bulan'] = $this->bulan;
            $this->data['tahun'] = $this->tahun;
        } else {
            $this->tanggal_mulai   = $validated['tanggal_mulai']   ?? Carbon::now()->startOfMonth()->format('Y-m-d');
            $this->tanggal_selesai = $validated['tanggal_selesai'] ?? Carbon::now()->endOfMonth()->format('Y-m-d');
            $this->data['tanggal_mulai']   = $this->tanggal_mulai;
            $this->data['tanggal_selesai'] = $this->tanggal_selesai;
        }

        $chart = $this->getChartData();
        $this->dispatch('chart-update',
            labels:     $chart['labels'],
            transaksi:  $chart['transaksi'],
            pendapatan: $chart['pendapatan'],
        );
    }

    public function setBulanIni(): void
    {
        $this->data['mode']  = 'bulanan';
        $this->data['bulan'] = Carbon::now()->format('m');
        $this->data['tahun'] = Carbon::now()->format('Y');
        $this->tampilkan();
    }

    public function getSummary(): ?object
    {
        $query = Transaksi::query()->where('status', 'keluar');

        if ($this->mode === 'bulanan') {
            $query->whereYear('waktu_keluar', $this->tahun)
                  ->whereMonth('waktu_keluar', $this->bulan);
        } else {
            if ($this->tanggal_mulai && $this->tanggal_selesai) {
                $query->whereBetween(DB::raw('DATE(waktu_keluar)'), [
                    $this->tanggal_mulai,
                    $this->tanggal_selesai,
                ]);
            }
        }

        return $query->selectRaw('
            COUNT(*) as total_transaksi,
            SUM(biaya_total) as total_pendapatan,
            COUNT(DISTINCT DATE(waktu_keluar)) as total_hari
        ')->first();
    }

    public function getChartData(): array
    {
        if ($this->mode === 'bulanan') {
            return $this->getChartBulanan();
        }

        return $this->getChartRentang();
    }

    private function getChartBulanan(): array
    {
        $tahun = (int) $this->tahun;
        $bulan = (int) $this->bulan;

        $start = Carbon::create($tahun, $bulan, 1)->startOfDay();
        $end   = $start->copy()->endOfMonth()->startOfDay();

        $namaBulanPendek = [
            1=>'Jan', 2=>'Feb',  3=>'Mar', 4=>'Apr',
            5=>'Mei', 6=>'Jun',  7=>'Jul', 8=>'Agu',
            9=>'Sep', 10=>'Okt', 11=>'Nov', 12=>'Des',
        ];
        $bln    = $namaBulanPendek[$bulan];
        $endDay = (int) $end->format('d');

        $weekRanges = [
            [1,  7],
            [8,  14],
            [15, 21],
            [22, $endDay],
        ];

        $labels = $transaksi = $pendapatan = [];

        foreach ($weekRanges as $i => $range) {
            $fromDate = Carbon::create($tahun, $bulan, $range[0])->format('Y-m-d');
            $toDate   = Carbon::create($tahun, $bulan, $range[1])->format('Y-m-d');

            $label = 'Minggu ' . ($i + 1) . "\n"
                   . str_pad($range[0], 2, '0', STR_PAD_LEFT) . '–'
                   . str_pad($range[1], 2, '0', STR_PAD_LEFT) . ' ' . $bln;

            $row = DB::table('tb_transaksi')
                ->where('status', 'keluar')
                ->whereBetween(DB::raw('DATE(waktu_keluar)'), [$fromDate, $toDate])
                ->selectRaw('COUNT(*) as total_transaksi, SUM(biaya_total) as total_pendapatan')
                ->first();

            $labels[]     = $label;
            $transaksi[]  = (int)   ($row->total_transaksi  ?? 0);
            $pendapatan[] = (float) ($row->total_pendapatan ?? 0);
        }

        return compact('labels', 'transaksi', 'pendapatan');
    }

    private function getChartRentang(): array
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) {
            return ['labels' => [], 'transaksi' => [], 'pendapatan' => []];
        }

        $rows = DB::table('tb_transaksi')
            ->where('status', 'keluar')
            ->whereBetween(DB::raw('DATE(waktu_keluar)'), [
                $this->tanggal_mulai,
                $this->tanggal_selesai,
            ])
            ->selectRaw('DATE(waktu_keluar) as tanggal, COUNT(*) as total_transaksi, SUM(biaya_total) as total_pendapatan')
            ->groupBy(DB::raw('DATE(waktu_keluar)'))
            ->orderBy('tanggal')
            ->get();

        $period = Carbon::parse($this->tanggal_mulai)
            ->daysUntil(Carbon::parse($this->tanggal_selesai)->addDay());

        $map        = $rows->keyBy('tanggal');
        $labels     = $transaksi = $pendapatan = [];

        foreach ($period as $date) {
            $key          = $date->format('Y-m-d');
            $labels[]     = $date->format('d/m');
            $transaksi[]  = (int)   ($map[$key]->total_transaksi  ?? 0);
            $pendapatan[] = (float) ($map[$key]->total_pendapatan ?? 0);
        }

        return compact('labels', 'transaksi', 'pendapatan');
    }

    public function getPeriodeLabel(): string
    {
        if ($this->mode === 'rentang' && $this->tanggal_mulai && $this->tanggal_selesai) {
            $from = Carbon::parse($this->tanggal_mulai)->format('d/m/Y');
            $to   = Carbon::parse($this->tanggal_selesai)->format('d/m/Y');
            return $from === $to ? $from : "$from — $to";
        }

        $namaBulan = [
            '01'=>'Januari',  '02'=>'Februari', '03'=>'Maret',
            '04'=>'April',    '05'=>'Mei',       '06'=>'Juni',
            '07'=>'Juli',     '08'=>'Agustus',   '09'=>'September',
            '10'=>'Oktober',  '11'=>'November',  '12'=>'Desember',
        ];
        return ($namaBulan[$this->bulan] ?? $this->bulan) . ' ' . $this->tahun;
    }
}
