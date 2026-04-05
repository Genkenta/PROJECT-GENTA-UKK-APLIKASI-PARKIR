<?php

namespace App\Filament\Admin\Resources\AreaParkir\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class AreaParkirForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_area')
                    ->required(),

                TextInput::make('kapasitas')
                    ->numeric()
                    ->required(),

                TextInput::make('terisi')
                    ->numeric()
                    ->required(),
            ]);
    }
}
