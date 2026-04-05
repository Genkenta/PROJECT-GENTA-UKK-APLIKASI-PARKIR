<?php

namespace App\Filament\Admin\Resources\AreaParkir;

use App\Filament\Admin\Resources\AreaParkir\Pages\CreateAreaParkir;
use App\Filament\Admin\Resources\AreaParkir\Pages\EditAreaParkir;
use App\Filament\Admin\Resources\AreaParkir\Pages\ListAreaParkir;
use App\Filament\Admin\Resources\AreaParkir\Schemas\AreaParkirForm;
use App\Filament\Admin\Resources\AreaParkir\Tables\AreaParkirTable;
use App\Models\AreaParkir;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AreaParkirResource extends Resource
{
    protected static ?string $model = AreaParkir::class;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'Area Parkir';

    protected static ?string $modelLabel = 'Area Parkir';

    protected static ?string $pluralModelLabel = 'Area Parkir';

    public static function getRecordTitle($record): string
    {
        return "{$record->nama_area} - {$record->kapasitas} | {$record->terisi}";
    }
    public static function getGloballySearchableAttributes(): array
    {
        return [
           'nama_area',
           'kapasitas',
           'terisi',
        ];
    }

    protected static ?string $slug = 'area-parkir';

    public static function form(Schema $schema): Schema
    {
        return AreaParkirForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AreaParkirTable::configure($table);
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
            'index' => ListAreaParkir::route('/'),
            'create' => CreateAreaParkir::route('/create'),
            'edit' => EditAreaParkir::route('/{record}/edit'),
        ];
    }
}
