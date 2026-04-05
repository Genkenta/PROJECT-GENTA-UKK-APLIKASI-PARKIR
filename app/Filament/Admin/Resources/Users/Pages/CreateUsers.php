<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UsersResource;
use App\Helpers\LogHelper;
use Filament\Resources\Pages\CreateRecord;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

    protected function afterCreate(): void
{
    LogHelper::add(
        'Menambahkan user: ' . $this->record->nama_lengkap . 
        ' (' . $this->record->role . ')'
    );
}
protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }

}
