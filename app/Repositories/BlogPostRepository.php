<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
//use Illuminate\Contracts\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BlogCategoryRepository
 *
 * @package App\Repositories
 */

class BlogPostRepository extends CoreRepository
{
  /*
   * @return string
   */

    protected function getModelClass()
    {
        return Model::class;
    }
    /**
     *
     * @return LengthAwarePaginator
     */

    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'image',
            'is_published',
            'published_at',
            'user_id',
            'excerpt',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->where('is_published', 1)
            ->with(['categories' => function ($query){
                $query->select(['id', 'title']);
            },])
            ->paginate(25);

        return $result;
    }

    public function getAllWithPaginateDraft()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'image',
            'is_published',
            'published_at',
            'user_id',
            'excerpt',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->where('is_published', 0)
            ->with(['categories' => function ($query){
                $query->select(['id', 'title']);
            },])
            ->paginate(25);

        return $result;
    }

    public function getAllWithPaginateMain($pageSize, $category_id)
    {
        $columns = [
            'id',
            'title',
            'slug',
            'image',
            'is_published',
            'published_at',
            'user_id',
            'excerpt',
        ];

        $query = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->with(['categories' => function ($query){
                $query->select(['id', 'title']);
            },])

            ->where('is_published', 1);

        if ($category_id != null) {
            $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('id', $category_id);
            });
        }




        $result = $query->paginate($pageSize);

        return $result;
    }

    /**
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }
}

