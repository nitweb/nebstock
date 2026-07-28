<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Newsletter extends Model
{
    protected $guarded = [];

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];

    /**
     * Subscribe হওয়ার আগে token generate করো
     */
    protected static function booted(): void
    {
        static::creating(function ($newsletter) {
            $newsletter->unsubscribe_token = Str::random(40);
            $newsletter->subscribed_at = now();
        });
    }
}
