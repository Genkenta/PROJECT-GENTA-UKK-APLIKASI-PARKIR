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
use Filament\Forms\Components\Hidden;
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
                    // label tampil dengan benar
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

                // AREA PARKIR dengan nama area dan terisi
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
                    ->default(now())
                    ->disabled(),

                Hidden::make('waktu_keluar')
                   ->nullable(),

                Hidden::make('durasi_jam')
                ->nullable(),

                Hidden::make('biaya_total')
                ->nullable(),

                Hidden::make('status')
               ->default('masuk'),

            ]);
    }
}
