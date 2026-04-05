<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifParkir extends Model
{
    use HasFactory;

    protected $table = 'tb_tarif';

    protected $primaryKey = 'id_tarif';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'jenis_kendaraan',
        'tarif_per_jam',
    ];

}