<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'author',
        'featured_image',
        'excerpt',
        'status',
        'published_at',
        'category',
        'keywords',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'keywords' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
