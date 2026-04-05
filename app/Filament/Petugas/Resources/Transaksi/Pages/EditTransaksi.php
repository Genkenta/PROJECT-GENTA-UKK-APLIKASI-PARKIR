<?php

namespace App\Filament\Petugas\Resources\Transaksi\Pages;

use App\Filament\Petugas\Resources\Transaksi\TransaksiResource;
use Filament\Actions\DeleteAction;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\EditRecord;

class EditTransaksi extends EditRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        LogHelper::add(
            'Mengedit transaksi: ' . $this->record->kode_transaksi .
                ' - ' . $this->record->kendaraan->plat_nomor
        );
    }

    protected function afterDelete(): void
    {
        LogHelper::add(
            'Menghapus transaksi: ' . $this->record->kode_transaksi .
                ' - ' . $this->record->kendaraan->plat_nomor
        );
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }
}
