<?php

namespace App\Filament\Admin\Resources\TarifParkir\Pages;

use App\Filament\Admin\Resources\TarifParkir\TarifParkirResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTarifParkir extends ListRecords
{
    protected static string $resource = TarifParkirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Tarif Parkir'),
        ];
    }
}
