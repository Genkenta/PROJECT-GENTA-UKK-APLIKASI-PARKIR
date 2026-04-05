<?php

namespace App\Filament\Petugas\Resources\Transaksi;

use App\Filament\Petugas\Resources\Transaksi\Pages\CreateTransaksi;
use App\Filament\Petugas\Resources\Transaksi\Pages\EditTransaksi;
use App\Filament\Petugas\Resources\Transaksi\Pages\ListTransaksi;
use App\Filament\Petugas\Resources\Transaksi\Schemas\TransaksiForm;
use App\Filament\Petugas\Resources\Transaksi\Tables\TransaksiTable;
use App\Models\Transaksi;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;


class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static ?string $navigationLabel = 'Transaksi';
    
    protected static ?string $modelLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?string $slug = 'transaksi';


    public static function form(Schema $schema): Schema
    {
        return TransaksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaksiTable::configure($table);
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
            'index' => ListTransaksi::route('/'),
            'create' => CreateTransaksi::route('/create'),
            'edit' => EditTransaksi::route('/{record}/edit'),
        ];
    }
}
