<?php

namespace App\Filament\Owner\Pages;

use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;
use App\Models\TransaksiRekap;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapTransaksi extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Document;
    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Rekap Transaksi';
    protected static ?string $title = 'Rekap Transaksi';
    protected static ?int $navigationSort = 2;
    protected string $view = 'filament.owner.pages.rekap-transaksi';

    public ?array $data = [];
    public string $tanggal_mulai = '';
    public string $tanggal_selesai = '';
    public bool $sudahFilter = false;

    public function mount(): void
    {
        $this->tanggal_mulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = Carbon::now()->format('Y-m-d');
        $this->sudahFilter = true;

        $this->form->fill([
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                DatePicker::make('tanggal_mulai')
                    ->label('Dari Tanggal')
                    ->required()
                    ->native(false),

                DatePicker::make('tanggal_selesai')
                    ->label('Sampai Tanggal')
                    ->required()
                    ->native(false)
                    ->afterOrEqual('tanggal_mulai'),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function tampilkan(): void
    {
        $validated = $this->form->getState();
        $this->tanggal_mulai = $validated['tanggal_mulai'];
        $this->tanggal_selesai = $validated['tanggal_selesai'];
        $this->sudahFilter = true;
        $this->resetTable();
    }

    public function setHariIni(): void
    {
        $today = Carbon::now()->format('Y-m-d');
        $this->data['tanggal_mulai'] = $today;
        $this->data['tanggal_selesai'] = $today;
        $this->tampilkan();
    }

    public function setMingguIni(): void
    {
        $this->data['tanggal_mulai'] = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->data['tanggal_selesai'] = Carbon::now()->endOfWeek()->format('Y-m-d');
        $this->tampilkan();
    }

    public function setBulanIni(): void
    {
        $this->data['tanggal_mulai'] = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->data['tanggal_selesai'] = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->tampilkan();
    }

    public function getSummary(): ?object
    {
        if (!$this->sudahFilter) return null;

        return Transaksi::query()
            ->whereBetween(DB::raw('DATE(waktu_keluar)'), [
                $this->tanggal_mulai,
                $this->tanggal_selesai,
            ])
            ->where('status', 'keluar') // hanya transaksi selesai
            ->selectRaw('
            COUNT(*) as total_transaksi,
            SUM(biaya_total) as total_pendapatan,
            COUNT(DISTINCT DATE(waktu_keluar)) as total_hari
        ')
            ->first();
    }
    public function table(Table $table): Table
    {
        $subquery = DB::table('tb_transaksi')
            ->select([
                DB::raw('MIN(id_parkir) as id_parkir'),
                DB::raw('DATE(waktu_keluar) as tanggal'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(biaya_total) as total_pendapatan'),
            ])
            ->where('status', 'keluar')
            ->when(
                $this->sudahFilter,
                fn($q) =>
                $q->whereBetween(DB::raw('DATE(waktu_keluar)'), [
                    $this->tanggal_mulai,
                    $this->tanggal_selesai,
                ])
            )
            ->groupBy(DB::raw('DATE(waktu_keluar)'));

        return $table
            ->query(
                TransaksiRekap::query()
                    ->fromSub($subquery, 'rekap')
            )
            ->defaultSort('tanggal', 'desc')
            ->modifyQueryUsing(fn($query) => $query->reorder('tanggal', 'desc'))
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d F Y'),

                TextColumn::make('total_transaksi')
                    ->label('Jumlaah Kendaraan')
                    ->suffix(' kendaraan')
                    ->alignCenter()
                    ->summarize(Sum::make()->label('Total')),

                TextColumn::make('total_pendapatan')
                    ->label('Total Pendapatan')
                    ->money('IDR')
                    ->alignEnd()
                    ->summarize(Sum::make()->money('IDR')->label('Grand Total')),
            ])
            ->striped()
            ->emptyStateHeading('Belum ada data')
            ->emptyStateDescription('Pilih periode dan klik Tampilkan');
    }
}
