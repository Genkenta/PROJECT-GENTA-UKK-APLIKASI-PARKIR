<?php

namespace App\Filament\Owner\Pages;

use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
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

    public function mount(): void
    {
        $this->mode  = 'bulanan';
        $this->bulan = Carbon::now()->format('m');
        $this->tahun = Carbon::now()->format('Y');

        $this->form->fill([
            'mode'  => $this->mode,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        '01' => 'Januari',  '02' => 'Februari', '03' => 'Maret',
                        '04' => 'April',    '05' => 'Mei',       '06' => 'Juni',
                        '07' => 'Juli',     '08' => 'Agustus',   '09' => 'September',
                        '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember',
                    ]),

                Select::make('tahun')
                    ->label('Tahun')
                    ->options(collect(range(Carbon::now()->year, Carbon::now()->year - 4))
                        ->mapWithKeys(fn ($y) => [$y => (string) $y])
                        ->toArray()),
            ])
            ->columns(4)
            ->statePath('data');
    }

    public function tampilkan(): void
    {
        $validated   = $this->form->getState();
        $this->bulan = $validated['bulan'] ?? Carbon::now()->format('m');
        $this->tahun = $validated['tahun'] ?? Carbon::now()->format('Y');

        $this->data['bulan'] = $this->bulan;
        $this->data['tahun'] = $this->tahun;

        $chart = $this->getChartData();
        $this->dispatch('chart-update',
            labels:     $chart['labels'],
            transaksi:  $chart['transaksi'],
            pendapatan: $chart['pendapatan'],
        );
    }

    public function setBulanIni(): void
    {
        $this->data['bulan'] = Carbon::now()->format('m');
        $this->data['tahun'] = Carbon::now()->format('Y');
        $this->tampilkan();
    }

    public function getSummary(): ?object
    {
        return Transaksi::query()
            ->where('status', 'keluar')
            ->whereYear('waktu_keluar', $this->tahun)
            ->whereMonth('waktu_keluar', $this->bulan)
            ->selectRaw('
                COUNT(*) as total_transaksi,
                SUM(biaya_total) as total_pendapatan,
                COUNT(DISTINCT DATE(waktu_keluar)) as total_hari
            ')->first();
    }

    public function getChartData(): array
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
        $bln = $namaBulanPendek[$bulan];

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

    public function getPeriodeLabel(): string
    {
        $namaBulan = [
            '01'=>'Januari',  '02'=>'Februari', '03'=>'Maret',
            '04'=>'April',    '05'=>'Mei',       '06'=>'Juni',
            '07'=>'Juli',     '08'=>'Agustus',   '09'=>'September',
            '10'=>'Oktober',  '11'=>'November',  '12'=>'Desember',
        ];
        return ($namaBulan[$this->bulan] ?? $this->bulan) . ' ' . $this->tahun;
    }
}
