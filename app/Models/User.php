<?php

namespace App\Models;
use App\Models\Berita;
use App\Models\Tugas;
use App\Models\Library;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- Penting untuk API Only (Sanctum)

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable; // <-- Tambahkan HasApiTokens di sini

    // Menyesuaikan dengan nama tabel kamu di database (singular 'user')
    protected $table = 'user';

    // Kolom yang boleh diisi (mass assignable) sesuai skema database kamu
    protected $fillable = [
        'user',     // Sesuai DBML: user varchar(255)
        'email',
        'role',     // Sesuai DBML: role varchar(30)
        'password', // Dibutuhkan oleh Laravel Auth / Breeze
    ];

    // Kolom yang disembunyikan saat data user di-convert ke JSON (misal saat response API)
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

    // --- RELASI KE TABEL LAIN (Sesuai DBML kamu) ---

    public function berita(): HasMany
    {
        return $this->hasMany(berita::class, 'user_id');
    }

    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class, 'user_id');
    }

    public function library(): HasMany
    {
        return $this->hasMany(Library::class, 'user_id');
    }
}   