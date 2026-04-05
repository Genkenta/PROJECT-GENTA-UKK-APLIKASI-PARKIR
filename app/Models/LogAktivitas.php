<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'tb_log_aktivitas';
    protected $primaryKey = 'id_log';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'aktivitas',
        'waktu_aktivitas',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}

}
