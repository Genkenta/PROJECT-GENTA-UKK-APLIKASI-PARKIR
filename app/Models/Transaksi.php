<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_parkir';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'id_tarif',
        'durasi_jam',
        'biaya_total',
        'status',
        'id_user',
        'id_area',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tarif()
    {
        return $this->belongsTo(TarifParkir::class, 'id_tarif');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }

    public function area()
    {
        return $this->belongsTo(AreaParkir::class, 'id_area');
    }

    protected static function booted()
    {
        static::created(function ($transaksi) {
            if ($transaksi->status === 'masuk') {
                $area = $transaksi->area;

                if ($area && $area->terisi < $area->kapasitas) {
                    $area->increment('terisi');
                }
            }
        });

        static::updated(function ($transaksi) {
            if ($transaksi->isDirty('status') && $transaksi->status === 'keluar') {
                $area = $transaksi->area;

                if ($area && $area->terisi > 0) {
                    $area->decrement('terisi');
                }
            }
        });
    }
}
