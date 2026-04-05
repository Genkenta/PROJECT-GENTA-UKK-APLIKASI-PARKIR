<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiRekap extends Model
{
    protected $table = 'rekap'; 
    protected $primaryKey = 'tanggal';
    public $keyType = 'string'; 
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}