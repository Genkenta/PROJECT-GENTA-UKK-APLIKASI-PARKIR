<?php

namespace App\Filament\Admin\Resources\Kendaraan\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;


class KendaraanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('plat_nomor')
                    ->required(),

                Select::make('jenis_kendaraan')
                    ->options([
                        'motor' => 'Motor',
                        'mobil' => 'Mobil',
                        'lainnya' => 'Lainnya',
                    ])
                    ->required(),

                TextInput::make('warna')
                    ->required(),

                TextInput::make('pemilik')
                    ->label('Nama Pemilik')
                    ->required(),

            ]);
    }
}
