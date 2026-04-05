<?php

namespace App\Filament\Admin\Resources\TarifParkir\Pages;

use App\Filament\Admin\Resources\TarifParkir\TarifParkirResource;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateTarifParkir extends CreateRecord
{
    protected static string $resource = TarifParkirResource::class;

    protected function afterCreate(): void
{
    LogHelper::add(
        'Menambahkan tarif ' . $this->record->jenis_kendaraan . 
        ' (Rp' . $this->record->tarif_per_jam . '/jam)'
    );
}
protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }

}
