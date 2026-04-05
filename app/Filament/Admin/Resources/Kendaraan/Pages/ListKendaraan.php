<?php

namespace App\Filament\Admin\Resources\Kendaraan\Pages;

use App\Filament\Admin\Resources\Kendaraan\KendaraanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKendaraan extends ListRecords
{
    protected static string $resource = KendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Kendaraan'),
        ];
    }
}
