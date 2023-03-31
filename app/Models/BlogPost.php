<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory;

    use SoftDeletes;

    const UNKNOWN_USER = 1;

    protected $fillable
        = [
            'id',
            'title',
            'slug',
            'categories_id',
            'image',
            'excerpt',
            'content_raw',
            'is_published',
            'published_at',
        ];

    /**
     * Категории статьи.
     *
     * @return BelongsToMany
     */

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'post_category', 'blog_posts_id', 'blog_categories_id');
    }

    /**
     * Автор статьи.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        //Статья принадлежит пользователю
        return $this->belongsTo(User::class);

    }
}
