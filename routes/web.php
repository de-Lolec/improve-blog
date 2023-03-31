<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/',], function () {
    Route::get('/', [App\Http\Controllers\blog\HomeController::class, 'index'])
        ->name('blog.main');
    Route::get('/post/{id}', [App\Http\Controllers\blog\HomeController::class, 'post'])
        ->name('blog.view');
});

Auth::routes();

// Админка блога
Route::get('admin/', [App\Http\Controllers\blog\Admin\AdminController::class, 'index'])->name('admin')->middleware('role:admin|moderator');

// Черновики
Route::get('admin/draft', [App\Http\Controllers\blog\Admin\PostController::class, 'indexDraft'])->name('draft')->middleware('role:admin|moderator');

// Для модератора
$groupDataModerator = [
    'namespace' => 'App\Http\Controllers\Blog\Admin',
    'prefix' => 'admin/blog',
    'middleware' => ['role:admin|moderator'],
];

Route::group($groupDataModerator, function () {
    //BlogCategory
    $methods = ['index', 'edit', 'update'];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    //BlogPost
    Route::resource('posts', 'PostController')
        ->only($methods)
        ->names('blog.admin.posts');

});
// Для админа
$groupDataAdmin = [
    'namespace' => 'App\Http\Controllers\Blog\Admin',
    'prefix' => 'admin/blog',
    'middleware' => ['role:admin'],
];

Route::group($groupDataAdmin, function () {
    //BlogCategory
    $methods = ['create', 'store', 'destroy'];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    //BlogPost
    Route::resource('posts', 'PostController')
        ->only($methods)
        ->names('blog.admin.posts');
});
