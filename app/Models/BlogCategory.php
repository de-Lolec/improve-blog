<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ROOT = 1;

    protected $fillable
        = [
            'id',
            'title',
            'slug',
        ];

    /**
     * Получить родительскую категорию
     *
     * @return BelongsToMany
     */

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'post_category', 'blog_categories_id', 'blog_posts_id');
    }


    /**
     * Пиример аксесуара (Accessor)
     *
     * @return string
     */
    public function getParentTitleAttribute(): string
    {
        $title = $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Корень'
                : '???');
        return $title;
    }

    /**
     * Является ли текущий объект корневым
     *
     * @return bool
     */
    public function isRoot(): bool
    {
        return $this->id === BlogCategory::ROOT;

    }

}
