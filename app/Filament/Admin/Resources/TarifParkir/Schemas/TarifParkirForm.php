<?php

namespace App\Filament\Admin\Resources\TarifParkir\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use App\Models\TarifParkir;
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
    ->unique(
        table: TarifParkir::class,
        column: 'jenis_kendaraan',
        ignoreRecord: true,
    )
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
