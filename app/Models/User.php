<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\tbl_unit;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'nip',
        'username',
        'email',
        'password',
        'role_id',
        'unit_id',
        'profesi',
        'atasan_langsung',
        'status_user',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // app/Models/User.php
    public function unit()
    {
        return $this->belongsTo(tbl_unit::class, 'unit_id');
    }

    public function role()
    {
        return $this->belongsTo(tbl_role::class, 'role_id');
    }

    /**
     * Check if user has permission to a specific menu key
     */
    public function hasPermission($menuKey)
    {
        // Admin always has permission
        if ($this->role_id == 1) {
            return true;
        }

        return tbl_hak_akses::where('role_id', $this->role_id)
            ->where('menu_key', $menuKey)
            ->exists();
    }
}
