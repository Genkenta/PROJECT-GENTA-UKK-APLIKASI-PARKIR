<?php

namespace App\Filament\Petugas\Resources\Transaksi\Pages;

use App\Filament\Petugas\Resources\Transaksi\TransaksiResource;
use App\Models\Transaksi;
use App\Helpers\LogHelper;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_user'] = Auth::user()->id_user;
        $data['waktu_masuk'] = now();

        return $data;
    }
    // TAMBAHAN: Validasi sebelum simpan
    protected function beforeCreate(): void
    {
        $sudahParkir = Transaksi::where('id_kendaraan', $this->data['id_kendaraan'])
            ->where('status', 'masuk')
            ->exists();

        if ($sudahParkir) {
            Notification::make()
                ->title('Kendaraan sedang parkir!')
                ->body('Kendaraan ini tidak bisa ditambahkan karena masih aktif parkir.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        LogHelper::add(
            'Menambahkan transaksi: ' . $this->record->kode_transaksi .
                ' - ' . $this->record->kendaraan->plat_nomor .
                ' masuk'
        );
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // ← balik ke list
    }
}
