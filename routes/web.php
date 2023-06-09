<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

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


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//Admin
Route::get('/admin', [AdminController::class, 'index'])
->middleware('can:admin.index')
->name('admin.index');

Route::namespace('App\Http\Controllers')->prefix('admin')->group(function(){
   
Route::resource('articles', 'ArticleController')
->except('show')
->names('articles');

//Categorias
Route::resource('categories','CategoryController')
->except('show')
->names('categories');

//Comentarios
Route::resource('comments', 'CommentController')
->only('index', 'destroy')
->names('comments');

//Usuarios
Route::resource('users', 'UserController')
->except('create', 'store', 'show')
->names('users');

    
});
// Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
// Route::get('/articles/create', [ArticleController::class, 'create'])->name('article.create');
// Route::post('/articles', [ArticleController::class, 'store'])->name('article.store');

// Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('article.edit');
// Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('article.update');
// Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');
//Categorias
// Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
// Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
// Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');

//Artículos
Route::resource('articles',ArticleController::class)
->except('show')
->names('articles');

//Categorias
Route::resource('categories',CategoryController::class)
->except('show')
->names('categories');

//Comentarios
Route::resource('comments', CommentController::class)
->only('index', 'destroy')
->names('comments');

//Profile
Route::resource('profiles', ProfileController::class)
->except('show')
->names('profiles');

//Ver articulos
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('profiles/{profile}', [ProfileController::class, 'show'])->name('profiles.show');

//Ver articulos por categorias
Route::get('category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

//Guardar comentarios
Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');


Auth::routes();