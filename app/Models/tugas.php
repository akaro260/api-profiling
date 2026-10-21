<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'user_id',
        'nama_tugas',
        'link_tugas',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}