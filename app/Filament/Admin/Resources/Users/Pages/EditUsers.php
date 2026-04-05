<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UsersResource;
use Filament\Actions\DeleteAction;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\EditRecord;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
{
    LogHelper::add(
        'Mengedit user: ' . $this->record->nama_lengkap
    );
}

protected function afterDelete(): void
{
    LogHelper::add(
        'Menghapus user: ' . $this->record->nama_lengkap
    );
}
protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }

}
