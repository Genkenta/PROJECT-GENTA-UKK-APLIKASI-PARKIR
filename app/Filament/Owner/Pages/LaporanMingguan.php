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
        $validated     = $this->form->getState();
        $this->bulan   = $validated['bulan'] ?? Carbon::now()->format('m');
        $this->tahun   = $validated['tahun'] ?? Carbon::now()->format('Y');
        $this->dispatch('chart-update');
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

        $start = Carbon::create($tahun, $bulan, 1);
        $end   = $start->copy()->endOfMonth();

        $weeks = [
            ['label' => 'Minggu 1', 'from' => $start->copy()->startOfMonth(),             'to' => $start->copy()->startOfMonth()->addDays(6)],
            ['label' => 'Minggu 2', 'from' => $start->copy()->startOfMonth()->addDays(7), 'to' => $start->copy()->startOfMonth()->addDays(13)],
            ['label' => 'Minggu 3', 'from' => $start->copy()->startOfMonth()->addDays(14),'to' => $start->copy()->startOfMonth()->addDays(20)],
            ['label' => 'Minggu 4', 'from' => $start->copy()->startOfMonth()->addDays(21),'to' => $end],
        ];

        $labels = $transaksi = $pendapatan = [];

        foreach ($weeks as $week) {
            $from = $week['from']->format('Y-m-d');
            $to   = min($week['to']->format('Y-m-d'), $end->format('Y-m-d'));

            $row = DB::table('tb_transaksi')
                ->where('status', 'keluar')
                ->whereBetween(DB::raw('DATE(waktu_keluar)'), [$from, $to])
                ->selectRaw('COUNT(*) as total_transaksi, SUM(biaya_total) as total_pendapatan')
                ->first();

            $labels[]     = $week['label'];
            $transaksi[]  = (int) ($row->total_transaksi ?? 0);
            $pendapatan[] = (float) ($row->total_pendapatan ?? 0);
        }

        return compact('labels', 'transaksi', 'pendapatan');
    }

    public function getPeriodeLabel(): string
    {
        $namaBulan = [
            '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April',
            '05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus',
            '09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember',
        ];
        return ($namaBulan[$this->bulan] ?? $this->bulan) . ' ' . $this->tahun;
    }
}