<?php

namespace App\Filament\Admin\Resources\LogAktivitas;

use App\Filament\Admin\Resources\LogAktivitas\Pages\ViewLogAktivitas;
use App\Filament\Admin\Resources\LogAktivitas\Pages\ListLogAktivitas;
use App\Filament\Admin\Resources\LogAktivitas\Schemas\LogAktivitasForm;
use App\Filament\Admin\Resources\LogAktivitas\Tables\LogAktivitasTable;
use App\Models\LogAktivitas;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LogAktivitasResource extends Resource
{
    protected static ?string $model = LogAktivitas::class;

    protected static string|UnitEnum|null $navigationGroup = 'Log';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Log Aktivitas';


    protected static ?string $recordTitleAttribute = 'aktivitas';

    protected static ?string $slug = 'log-aktivitas';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return LogAktivitasTable::configure($table);
    }

   public static function infolist(Schema $schema): Schema
{
    return $schema
        ->components([
            TextEntry::make('user.nama_lengkap')
                ->label('User'),

            TextEntry::make('aktivitas')
                ->label('Aktivitas')
                ->badge()
                ->color('primary'),

            TextEntry::make('waktu_aktivitas')
                ->label('Waktu')
                ->icon('heroicon-o-clock')
                ->dateTime('d M Y, H:i'),
        ]);
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
            'index' => ListLogAktivitas::route('/'),
            'view' => ViewLogAktivitas::route('/{record}'),
        ];
    }
}
