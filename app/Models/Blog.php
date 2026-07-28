<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'submitted_at'        => 'datetime',
        'blog_published_date' => 'date',
    ];

    // Admin যে publish করেছে
    public function blogPublisher()
    {
        return $this->belongsTo(Admin::class, 'blog_published_by');
    }

    // Category
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategories::class, 'blog_category_id');
    }

    // Frontend user যে submit করেছে
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
