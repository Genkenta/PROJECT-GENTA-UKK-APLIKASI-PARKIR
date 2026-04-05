<?php

namespace App\Filament\Petugas\Resources\Transaksi\Pages;

use App\Filament\Petugas\Resources\Transaksi\TransaksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransaksi extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Transaksi'),
        ];
    }
}
