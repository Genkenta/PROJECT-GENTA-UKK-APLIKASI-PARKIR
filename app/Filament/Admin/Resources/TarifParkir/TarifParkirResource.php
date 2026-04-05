<?php

namespace App\Filament\Admin\Resources\TarifParkir;

use App\Filament\Admin\Resources\TarifParkir\Pages\CreateTarifParkir;
use App\Filament\Admin\Resources\TarifParkir\Pages\EditTarifParkir;
use App\Filament\Admin\Resources\TarifParkir\Pages\ListTarifParkir;
use App\Filament\Admin\Resources\TarifParkir\Schemas\TarifParkirForm;
use App\Filament\Admin\Resources\TarifParkir\Tables\TarifParkirsTable;
use App\Models\TarifParkir;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TarifParkirResource extends Resource
{
    protected static ?string $model = TarifParkir::class;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $navigationLabel = 'Tarif Parkir'; 

    public static function getRecordTitle($record): string
{
    return "{$record->jenis_kendaraan} - {$record->tarif_per_jam}";
}
    public static function getGloballySearchableAttributes(): array
{
    return [
        'jenis_kendaraan',
        'tarif_per_jam',
    ];
}

    protected static ?string $modelLabel = 'Tarif Parkir';

    protected static ?string $pluralModelLabel = 'Tarif Parkir';

    protected static ?string $slug = 'tarif-parkir';


    public static function form(Schema $schema): Schema
    {
        return TarifParkirForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TarifParkirsTable::configure($table);
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
            'index' => ListTarifParkir::route('/'),
            'create' => CreateTarifParkir::route('/create'),
            'edit' => EditTarifParkir::route('/{record}/edit'),
        ];
    }
}
