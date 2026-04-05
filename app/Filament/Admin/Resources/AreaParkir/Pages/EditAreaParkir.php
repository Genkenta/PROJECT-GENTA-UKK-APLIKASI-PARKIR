<?php

namespace App\Filament\Admin\Resources\AreaParkir\Pages;

use App\Filament\Admin\Resources\AreaParkir\AreaParkirResource;
use Filament\Actions\DeleteAction;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\EditRecord;

class EditAreaParkir extends EditRecord
{
    protected static string $resource = AreaParkirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        LogHelper::add('Mengedit area parkir: ' . $this->record->nama_area);
    }

    protected function afterDelete(): void
    {
        LogHelper::add('Menghapus area parkir: ' . $this->record->nama_area);
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }
}
