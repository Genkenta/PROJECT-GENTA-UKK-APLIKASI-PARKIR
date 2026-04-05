<?php

namespace App\Filament\Petugas\Resources\Transaksi\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Carbon\Carbon;

class TransaksiTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id_parkir')
                    ->label('ID Parkir')
                    ->sortable(),

                TextColumn::make('user.username')
                    ->label('Petugas')
                    ->searchable(),


                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Kendaraan')
                    ->formatStateUsing(function ($state, $record) {
                        $pemilik = $record->kendaraan?->pemilik ?? '-';
                        $jenis_kendaraan = $record->kendaraan?->jenis_kendaraan ?? '-';
                        return $state . ' - ' . $jenis_kendaraan . ' - ' . $pemilik;
                    })
                    ->searchable(),

                TextColumn::make('area.nama_area')
                    ->label('Area'),

                TextColumn::make('waktu_masuk')
                    ->label('Waktu Masuk')
                    ->dateTime('d M Y H:i'),

                TextColumn::make('waktu_keluar')
                    ->label('Waktu Keluar')
                    ->dateTime('d M Y H:i'),

                TextColumn::make('durasi_jam')
                    ->label('Durasi')
                    ->formatStateUsing(fn($state) => $state . ' Jam'),

                TextColumn::make('biaya_total')
                    ->label('Biaya')
                    ->money('IDR'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'masuk',
                        'success' => 'keluar',
                    ]),

            ])

            ->emptyStateHeading('Tidak ada transaksi')
            ->emptyStateDescription('Belum ada data transaksi yang masuk')

            ->filters([
                //
            ])

            ->recordActions([

                EditAction::make(),

                Action::make('keluar')
                    ->label('Kendaraan Keluar')
                    ->color('success')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->visible(fn($record) => $record->status === 'masuk')
                    ->action(function ($record) {

                        $waktuKeluar = now();

                        $durasi = max(1, ceil(
                            Carbon::parse($record->waktu_masuk)
                                ->diffInMinutes($waktuKeluar) / 60
                        ));
                        $tarif = $record->tarif?->tarif_per_jam ?? 0;


                        $biaya = $durasi * $tarif;

                        $record->update([
                            'status' => 'keluar',
                            'waktu_keluar' => $waktuKeluar,
                            'durasi_jam' => $durasi,
                            'biaya_total' => $biaya,
                        ]);
                    }),
                Action::make('cetak')
                    ->label('Cetak Struk')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn($record) => route('struk.print', $record->id_parkir))
                    ->openUrlInNewTab()
                    ->visible(fn($record) => $record->status === 'keluar'),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
