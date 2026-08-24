<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'tool',
        'topic',
        'tone',
        'content',
        'word_count',
        'char_count',
        'provider',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
