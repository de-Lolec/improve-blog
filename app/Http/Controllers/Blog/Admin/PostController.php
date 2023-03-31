<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;


class PostController extends BaseController
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
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return view("blog.admin.posts.index", compact('paginator'));
    }

    public function indexDraft()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginateDraft();

        return view("blog.admin.posts.draft", compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryIds = $item->categories->pluck('id')->toArray();
        $categories = BlogCategory::all();
        $categoryList = $categories->pluck('title', 'id')->all();

        return view('blog.admin.posts.create',
            compact('item', 'categoryList', 'categoryIds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $request->image->extension();
            $image->move(public_path('image'), $imageName);
            $data['image'] = $imageName;
        }

        $item = (new BlogPost())->create($data);
        if ($item) {
            $categories = $request->input('categories');
            $item->categories()->attach($categories);
        }
        if ($item) {
            return redirect()->route('blog.admin.posts.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        $categoryIds = $item->categories->pluck('id')->toArray();
        $categories = BlogCategory::all();
        $categoryList = $categories->pluck('title', 'id')->all();

        return view('blog.admin.posts.edit',
            compact('item', 'categoryList', 'categoryIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        $item->save();

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись {$id} не найдена"])
                ->withInput();
        }

        $data = $request->input();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $request->image->extension();
            $image->move(public_path('image'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->has('remove') && $item->image) {
            unlink('image\\' . $item->image);
            $item->image = null;
        }

        $categories = $request->input('categories');
        $item->categories()->sync($categories);

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успешно сохранено ']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //софт-удаление, в бд остается
        $result = BlogPost::destroy($id);

        // полное удаление из бд
        // $result = BlogPost::find($id)->forceDelete();

        if ($result) {
            return redirect()
                ->route('blog.admin.posts.index')
                ->with(['success' => "Запись $id удалена"]);
        } else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
