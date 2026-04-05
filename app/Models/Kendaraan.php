<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;


    protected $table = 'tb_kendaraan';
    protected $primaryKey = 'id_kendaraan';
    public $incrementing = true;
protected $keyType = 'int';
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'pemilik',
        'id_user',
    ];

}
