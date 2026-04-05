<?php
namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName; // tambahkan ini
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName // tambahkan HasName
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';

    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'nama_lengkap',
        'username',
        'password',
        'role',
        'status_aktif',
    ];
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getFilamentName(): string
    {
        return (string) ($this->username ?? $this->nama_lengkap ?? 'User');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

}