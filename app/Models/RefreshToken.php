<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefreshToken extends Model
{
    use SoftDeletes;

    protected $table = 'refresh_tokens';

    protected $fillable = [
        'Token', 'user_id', 'ExpiresAt', 'IsRevoked', 'RevokedAt'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}