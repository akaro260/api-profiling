<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'user_id',
        'gambar',
        'judul',
        'isian',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}