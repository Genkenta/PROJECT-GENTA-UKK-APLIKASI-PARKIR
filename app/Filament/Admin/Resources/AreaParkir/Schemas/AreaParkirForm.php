<?php

namespace App\Filament\Admin\Resources\AreaParkir\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;

class AreaParkirForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_area')
                ->required()
                ->unique(
                table: 'tb_area_parkir',
                column: 'nama_area',
                ignorable: fn ($record) => $record,
 )
              ->validationMessages([
              'unique' => 'Nama area sudah ada, masukkan nama area yang lain.',
]),
                TextInput::make('kapasitas')
                    ->numeric()
                    ->required(),

    
            ]);
    }
}
