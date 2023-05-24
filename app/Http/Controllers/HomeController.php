<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        #Obtener los articulos publicos(1)
        $articles = Article::where('status', 1)
            ->orderBy('id', 'desc')
            ->simplePaginate(10);

        #Obtener las cateogrias publicos(1) y destacadas (1)
        $navbar = Category::where([
            ['status', 1],
            ['is_featured', 1],
        ])->paginate(3);

        return view('home.index', compact('articles', 'navbar'));
    }

   
    public function all(){

         //Todas las categorias
        $categories = Category::where('status', 1)
        ->simplePaginate(20);

         #Obtener las categorias publicos(1) y destacadas (1)
         $navbar = Category::where([
            ['status', 1],
            ['is_featured', 1],
        ])->paginate(3);

        return view('home.all-categories', compact('categories', 'navbar'));
    }
}
