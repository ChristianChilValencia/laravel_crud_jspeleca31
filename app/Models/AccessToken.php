<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccessToken extends Model
{
    protected $fillable = ['user_id', 'token', 'expires_at'];
    
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Deprecated: use controller logic for single token per user with expiry
    // public static function generate(User $user)
    // {
    //     $existing = self::where('user_id', $user->id)
    //                     ->where('expires_at', '>', now())
    //                     ->first();
    //
    //     if ($existing) {
    //         return $existing->token;
    //     }
    //
    //     $token = Str::random(60);
    //     self::create([
    //         'user_id' => $user->id,
    //         'token' => $token,
    //         'expires_at' => now()->addDay(),
    //     ]);
    //
    //     return $token;
    // }

    public static function isValid($token)
    {
        return self::where('token', $token)
                   ->where('expires_at', '>', now())
                   ->exists();
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
