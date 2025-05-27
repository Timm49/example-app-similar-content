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

    public function getEmbeddingData(): string
    {
        $embedData = collect($this->getFillable())
            ->mapWithKeys(fn ($key) => [$key => $this->getAttribute($key)])
            ->toArray();

        return json_encode($embedData);
    }
}
