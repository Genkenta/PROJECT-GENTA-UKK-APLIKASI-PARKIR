<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTransaksi extends BaseWidget
{
    protected static ?string $heading = 'Rekap Transaksi Terbaru';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    // Tab aktif: 'semua', 'masuk', 'keluar'
    public string $activeTab = 'semua';

    protected function getFooter(): ?\Illuminate\Contracts\View\View
    {
        $total = Transaksi::sum('biaya_total');
        $count = Transaksi::count();
        $max   = Transaksi::max('biaya_total') ?? 0;
        $min   = Transaksi::whereNotNull('waktu_keluar')->min('biaya_total') ?? 0;

        $avgMenit = Transaksi::whereNotNull('waktu_keluar')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, waktu_masuk, waktu_keluar)) as avg_durasi')
            ->value('avg_durasi') ?? 0;

        $jam       = intdiv((int) $avgMenit, 60);
        $sisa      = (int) $avgMenit % 60;
        $avgDurasi = $jam > 0 ? "{$jam}j {$sisa}m" : "{$sisa}m";

        return view('filament.widgets.transaksi-footer', [
            'total'     => 'Rp ' . number_format($total, 0, ',', '.'),
            'count'     => $count,
            'max'       => 'Rp ' . number_format($max, 0, ',', '.'),
            'min'       => 'Rp ' . number_format($min, 0, ',', '.'),
            'avgDurasi' => $avgDurasi,
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = Transaksi::query()->latest('waktu_masuk');

                return match ($this->activeTab) {
                    'masuk'  => $query->whereNull('waktu_keluar'),
                    'keluar' => $query->whereNotNull('waktu_keluar'),
                    default  => $query,
                };
            })
            ->columns([
                TextColumn::make('id_parkir')
                    ->label('Kode')
                    ->formatStateUsing(fn($state) => '#' . str_pad($state, 6, '0', STR_PAD_LEFT))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Kendaraan')
                    ->formatStateUsing(function ($state, $record) {
                        $jenis_kendaraan = $record->kendaraan?->jenis_kendaraan ?? '-';
                        return $state . ' - ' . $jenis_kendaraan;
                    })
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('waktu_masuk')
                    ->label('Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('waktu_keluar')
                    ->label('Keluar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('Masih parkir'),

                TextColumn::make('durasi')
                    ->label('Durasi')
                    ->badge()
                    ->color('warning')
                    ->getStateUsing(function (Transaksi $record): string {
                        $keluar = $record->waktu_keluar ?? now();
                        $menit  = Carbon::parse($record->waktu_masuk)->diffInMinutes($keluar);
                        $jam    = intdiv($menit, 60);
                        $sisa   = $menit % 60;
                        return $jam > 0 ? "{$jam}j {$sisa}m" : "{$sisa}m";
                    }),

                TextColumn::make('biaya_total')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'selesai' => 'success',
                        'aktif'   => 'warning',
                        'gagal'   => 'danger',
                        default   => 'gray',
                    }),
            ])
            ->emptyStateHeading('Tidak ada transaksi')
            ->emptyStateDescription('Belum ada data transaksi yang masuk')
            
            ->searchPlaceholder('Cari kode, plat, atau nominal...')
            ->headerActions([
                // Tab Semua / Masuk / Keluar menggunakan Action sebagai tombol tab
                Action::make('tab_semua')
                    ->label('Semua')
                    ->button()
                    ->color($this->activeTab === 'semua' ? 'warning' : 'gray')
                    ->action(function () {
                        $this->activeTab = 'semua';
                        $this->resetTable();
                    }),

                Action::make('tab_masuk')
                    ->label('Masuk')
                    ->button()
                    ->color($this->activeTab === 'masuk' ? 'warning' : 'gray')
                    ->action(function () {
                        $this->activeTab = 'masuk';
                        $this->resetTable();
                    }),

                Action::make('tab_keluar')
                    ->label('Keluar')
                    ->button()
                    ->color($this->activeTab === 'keluar' ? 'warning' : 'gray')
                    ->action(function () {
                        $this->activeTab = 'keluar';
                        $this->resetTable();
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('hari_ini')
                    ->label('Hari Ini')
                    ->query(fn($query) => $query->whereDate('created_at', today()))
                    ->toggle(),

                Tables\Filters\Filter::make('minggu_ini')
                    ->label('Minggu Ini')
                    ->query(fn($query) => $query->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ]))
                    ->toggle(),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif'   => 'Aktif',
                        'selesai' => 'Selesai',
                        'gagal'   => 'Gagal',
                    ]),
            ])
            ->defaultSort('waktu_masuk', 'desc')
            ->paginated([10, 25, 50])
            ->poll('30s');
    }
}
