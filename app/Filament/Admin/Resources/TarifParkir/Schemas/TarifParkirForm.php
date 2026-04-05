<?php

namespace App\Filament\Admin\Resources\TarifParkir\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class TarifParkirForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_kendaraan')
                ->label('Jenis Kendaraan')
                    ->options([
                        'motor'   => 'Motor',
                        'mobil'   => 'Mobil',
                        'lainnya' => 'Lainnya',
                    ])
                    ->required(),

                    TextInput::make('tarif_per_jam')
                    ->label('Tarif Per Jam')
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0)
                    ->required(),
            ]);
    }
}
