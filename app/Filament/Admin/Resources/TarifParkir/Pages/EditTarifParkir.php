<?php

namespace App\Filament\Admin\Resources\TarifParkir\Pages;

use App\Filament\Admin\Resources\TarifParkir\TarifParkirResource;
use Filament\Actions\DeleteAction;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\EditRecord;

class EditTarifParkir extends EditRecord
{
    protected static string $resource = TarifParkirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        LogHelper::add(
            'Mengedit tarif ' . $this->record->jenis_kendaraan
        );
    }

    protected function afterDelete(): void
    {
        LogHelper::add(
            'Menghapus tarif ' . $this->record->jenis_kendaraan
        );
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }
}
