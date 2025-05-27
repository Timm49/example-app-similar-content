<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Timm49\SimilarContentLaravel\Attributes\HasEmbeddings;
use Timm49\SimilarContentLaravel\Traits\HasSimilarContent;

#[HasEmbeddings]
class Article extends Model
{
    use HasFactory, SoftDeletes, HasSimilarContent;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'keywords' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
