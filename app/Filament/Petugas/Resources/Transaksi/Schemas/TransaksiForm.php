<?php

namespace App\Filament\Petugas\Resources\Transaksi\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\TarifParkir;
use App\Models\AreaParkir;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('id_kendaraan')
    ->label('Kendaraan')
    ->options(function () {
        // Ambil id kendaraan yang sedang aktif parkir (status masuk)
        $kendaraanAktif = Transaksi::where('status', 'masuk')
            ->pluck('id_kendaraan');

        // Hanya tampilkan kendaraan yang tidak sedang parkir
        return Kendaraan::whereNotIn('id_kendaraan', $kendaraanAktif)
            ->get()
            ->mapWithKeys(fn($k) => [
                $k->id_kendaraan => $k->plat_nomor . ' - ' . $k->jenis_kendaraan . ' - ' . $k->pemilik
            ]);
    })
    // ← TAMBAHAN INI: agar saat Edit label tampil dengan benar
    ->getOptionLabelUsing(function ($value) {
        $k = Kendaraan::find($value);
        if (!$k) return $value;
        return $k->plat_nomor . ' - ' . $k->jenis_kendaraan . ' - ' . $k->pemilik;
    })
    ->searchable()
    ->preload()
    ->required(),
                Select::make('id_tarif')
                    ->label('Tarif Kendaraan')
                    ->options(
                        TarifParkir::all()->mapWithKeys(function ($tarif) {
                            return [
                                $tarif->id_tarif => $tarif->jenis_kendaraan .
                                    ' - Rp ' . number_format($tarif->tarif_per_jam, 0, ',', '.') . ' / jam'
                            ];
                        })
                    )
                    ->searchable()
                    ->required(),

                TextInput::make('user_login')
                    ->label('Petugas')
                    ->default(fn() => Auth::user()->username)
                    ->readOnly()
                    ->dehydrated(false),

                // 🔥 AREA PARKIR (SUDAH DI-UPGRADE)
                Select::make('id_area')
                    ->label('Area Parkir')
                    ->options(function () {
                        return AreaParkir::all()->mapWithKeys(function ($area) {
                            $label = "{$area->nama_area} ({$area->terisi}/{$area->kapasitas})";

                            if ($area->terisi >= $area->kapasitas) {
                                $label .= ' - Penuh';
                            }

                            return [$area->id_area => $label];
                        });
                    })
                    ->disableOptionWhen(function ($value) {
                        $area = AreaParkir::find($value);

                        return $area && $area->terisi >= $area->kapasitas;
                    })
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                $area = AreaParkir::find($value);

                                if ($area && $area->terisi >= $area->kapasitas) {
                                    $fail('Area parkir sudah penuh!');
                                }
                            };
                        }
                    ])
                    ->searchable()
                    
                    ->required(),

                DateTimePicker::make('waktu_masuk')
                    ->label('Waktu Masuk')
                    ->readOnly(),

                DateTimePicker::make('waktu_keluar')
                    ->label('Waktu Keluar')
                    ->readOnly(),

                TextInput::make('durasi_jam')
                    ->label('Durasi (Jam)')
                    ->numeric()
                    ->readOnly(),

                TextInput::make('biaya_total')
                    ->label('Biaya Total')
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly(),

                Select::make('status')
                    ->options([
                        'masuk' => 'Masuk',
                        'keluar' => 'Keluar',
                    ])
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {

                        if ($state === 'masuk') {
                            $set('waktu_masuk', now());
                            $set('waktu_keluar', null);
                            $set('durasi_jam', null);
                            $set('biaya_total', null);
                        }

                        if ($state === 'keluar') {

                            $waktuMasuk = $get('waktu_masuk');
                            $waktuKeluar = now();

                            $set('waktu_keluar', $waktuKeluar);

                            if ($waktuMasuk) {
                                $durasi = Carbon::parse($waktuMasuk)
                                    ->diffInHours($waktuKeluar);

                                $set('durasi_jam', $durasi);

                                $tarif = TarifParkir::find($get('id_tarif'));

                                if ($tarif) {
                                    $biaya = $durasi * $tarif->tarif_per_jam;
                                    $set('biaya_total', $biaya);
                                }
                            }
                        }
                    })
                    ->required(),
            ]);
    }
}