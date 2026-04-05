<?php

namespace App\Filament\Admin\Resources\LogAktivitas\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class LogAktivitasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // ID (disembunyikan default)
                TextColumn::make('id_log')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Nama pengguna + role
                TextColumn::make('user.nama_lengkap')
                    ->label('Pengguna')
                    ->getStateUsing(
                        fn($record) =>
                        $record->user->nama_lengkap . ' (' . ucfirst($record->user->role) . ')'
                    )
                    ->searchable(),

                // Aktivitas
                TextColumn::make('aktivitas')
                    ->label('Aktivitas')
                    ->searchable()
                    ->wrap(),

                // Waktu aktivitas
                TextColumn::make('waktu_aktivitas')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->emptyStateHeading('Tidak ada log aktivitas')
            ->emptyStateDescription('Belum ada aktivitas yang tercatat')
            ->defaultSort('waktu_aktivitas', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                // ❌ Log biasanya tidak perlu diedit
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
