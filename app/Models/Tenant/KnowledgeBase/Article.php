<?php

declare(strict_types=1);

namespace App\Models\Tenant\KnowledgeBase;

use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $table = 'kb_articles';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'category_id',
        'author_id',
        'views_count',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'views_count' => 'integer',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            if ($article->is_published && empty($article->published_at)) {
                $article->published_at = now();
            }
        });

        static::updating(function ($article) {
            if ($article->is_published && empty($article->published_at)) {
                $article->published_at = now();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
