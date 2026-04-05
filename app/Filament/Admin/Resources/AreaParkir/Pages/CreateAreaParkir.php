<?php

namespace App\Filament\Admin\Resources\AreaParkir\Pages;

use App\Filament\Admin\Resources\AreaParkir\AreaParkirResource;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateAreaParkir extends CreateRecord
{
    protected static string $resource = AreaParkirResource::class;

    protected function afterCreate(): void
    {
        LogHelper::add('Menambahkan area parkir: ' . $this->record->nama_area);
    }
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }
}
