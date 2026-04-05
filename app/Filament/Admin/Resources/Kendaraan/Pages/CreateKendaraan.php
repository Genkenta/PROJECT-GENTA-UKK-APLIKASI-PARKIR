<?php

namespace App\Filament\Admin\Resources\Kendaraan\Pages;

use App\Filament\Admin\Resources\Kendaraan\KendaraanResource;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateKendaraan extends CreateRecord
{
    protected static string $resource = KendaraanResource::class;
    protected function afterCreate(): void
    {
         LogHelper::add(
            'Menambahkan kendaraan ' . $this->record->plat_nomor . 
            ' (' . $this->record->jenis_kendaraan . ')'
        );
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }
}
