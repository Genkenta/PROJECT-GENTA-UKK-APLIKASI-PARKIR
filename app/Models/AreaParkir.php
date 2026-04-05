<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaParkir extends Model
{
    use HasFactory;

    protected $table = 'tb_area_parkir';
    protected $primaryKey = 'id_area';
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
       'nama_area',
        'kapasitas',
        'terisi',
    ];

}
