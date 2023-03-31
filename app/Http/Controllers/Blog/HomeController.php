<?php

namespace App\Http\Controllers\blog;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Http\Request;
use App\Repositories\BlogPostRepository;

class HomeController extends BaseController
{

    private $blogPostRepository;

    private $blogPostRepositoryMain;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

        parent::__construct();
        //Частные свойства проинициализируем
        //Создание объекта blogPostRepository
        //Ларавель сам его создает
        //Не все обьекты надо так создавать
        $this->blogPostRepositoryMain = app(blogPostRepository::class);
        $this->blogCategoryRepository = app(blogCategoryRepository::class);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $request->session()->flash('page_size', request()->input('page_size', 10));
        $request->session()->flash('category_sort', request()->input('category_sort', null));
        $category_sort = $request->session()->get('category_sort');
        $pageSize = $request->session()->get('page_size', 10);

        $paginator = $this->blogPostRepositoryMain->getAllWithPaginateMain($pageSize, $category_sort);

        $categoryList = BlogCategory::all();

        return view("blog.main.index_main", compact('paginator', 'categoryList', 'pageSize', 'category_sort'));
    }


    public function post($id)
    {

        $item = BlogPost::find($id);
        // dd($item->comments);
        //  $comment = Comment::find($id);
        return view('blog.main.index_view',
            compact('item'));

    }
}
