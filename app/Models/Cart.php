<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Helper method: Get current cart query
    public static function getCurrentCart()
    {
        if (Auth::guard('user')->check()) {
            return self::where('user_id', Auth::guard('user')->id());
        }
        return self::where('session_id', session()->getId());
    }
}
