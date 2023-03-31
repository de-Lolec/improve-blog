<?php

namespace App\Http\Controllers\blog\Admin;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{

    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     * @var $BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct()
    {

        parent::__construct();

        $this->blogPostRepository = app(blogPostRepository::class);
        $this->blogCategoryRepository = app(blogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // $user = Auth::user()->find(9);
        //$user->assignRole('moderator');

        $posts = BlogPost::where('is_published', 1)->latest()->take(10)->get();
        $drafts = BlogPost::where('is_published', 0)->latest()->take(10)->get();
        $categories = BlogCategory::latest()->take(10)->get();
        // dd($category);

        return view("blog.admin.admin_panel", compact('posts', 'categories', 'drafts'));
    }
}
