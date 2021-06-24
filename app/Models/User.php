<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }

    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(Idea::class, 'votes');
    }

    public function getAvatar(): string
    {
        $firstChar = $this->email[0];

        $integerToUse = is_numeric($firstChar)
            ? ord(strtolower($firstChar)) - 21
            : ord(strtolower($firstChar)) - 96;

        return 'https://www.gravatar.com/avatar/'
            . md5($this->email)
            . '?s=200'
            . '&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-'
            . $integerToUse
            . '.png';
    }

    public function isAdmin(): bool
    {
        return in_array($this->email, [
            'hcakar.1992@gmail.com'
        ]);
    }
}
