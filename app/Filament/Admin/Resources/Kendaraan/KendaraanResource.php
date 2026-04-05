<?php

namespace App\Filament\Admin\Resources\Kendaraan;

use App\Filament\Admin\Resources\Kendaraan\Pages\CreateKendaraan;
use App\Filament\Admin\Resources\Kendaraan\Pages\EditKendaraan;
use App\Filament\Admin\Resources\Kendaraan\Pages\ListKendaraan;
use App\Filament\Admin\Resources\Kendaraan\Schemas\KendaraanForm;
use App\Filament\Admin\Resources\Kendaraan\Tables\KendaraanTable;
use App\Models\Kendaraan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KendaraanResource extends Resource
{
    protected static ?string $model = Kendaraan::class;
    
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $navigationLabel = 'Kendaraan';
    
    protected static ?string $modelLabel = 'Kendaraan';

   public static function getRecordTitle($record): string
{
    return "{$record->plat_nomor} - {$record->jenis_kendaraan} - {$record->warna} | {$record->pemilik}";
}
    public static function getGloballySearchableAttributes(): array
{
    return [
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'pemilik',
    ];
}

    protected static ?string $pluralModelLabel = 'Kendaraan';

    protected static ?string $slug = 'kendaraan';

    public static function form(Schema $schema): Schema
    {
        return KendaraanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KendaraanTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKendaraan::route('/'),
            'create' => CreateKendaraan::route('/create'),
            'edit' => EditKendaraan::route('/{record}/edit'),
        ];
    }
}
