<?php

namespace App\Filament\Admin\Resources\AreaParkir\Pages;

use App\Filament\Admin\Resources\AreaParkir\AreaParkirResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAreaParkir extends ListRecords
{
    protected static string $resource = AreaParkirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Area Parkir'),
        ];
    }
}
