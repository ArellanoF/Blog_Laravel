<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)
        ->orderBy('id', 'desc')
        ->simplePaginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //Obtener categorias publicas
       $categories = Category::select(['id', 'name'])
       ->where('status', 1)
       ->orderBy('name', 'asc')
       ->get();

       return view ('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
       /* Formulario */
       $request->merge([
        'user_id' => Auth::user()->id,
       ]);

       //Guardamos la solicitud en una variable
       $article = $request->all();

       if($request->hasFile('image')){
        $article['image'] = $request->file('image')->store('articles');
       }

       Article::create($article);

       return redirect()->action([ArticleController::class, 'index'])
       ->with('success-create', 'Artículo creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $this->authorize('published', $article);
        $comments = $article->comments()->simplePaginate(5);
        return view('subscriber.articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {

        $this->authorize('view', $article);
        //Obtener categorias publicas
       $categories = Category::select(['id', 'name'])
       ->where('status', 1)
       ->orderBy('name', 'asc')
       ->get();

       return view ('admin.articles.edit', compact('article','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);
        //si el usuario sube una nueva imagen
        if($request->hasFile('image')){
            //Eliminar la imagen anterior
            File::delete(public_path('storage/' . $article->image));
            //asignar nueva imagen
            $article['image'] = $request->file('image')->store('articles');
        }

        //Actualizar datos
        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'introduction' => $request->introduction,
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return redirect()->action([ArticleController::class, 'index'], compact ('article'))
        ->with('success-update', 'Artículo actualizado con éxito');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        // Guardar la ruta de la imagen antes de eliminar el artículo
        $imagePath = public_path('storage/' . $article->image);
        if ($article->delete()) {
            if ($article->image && File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return redirect()->action([ArticleController::class, 'index'], compact ('article'))
        ->with('success-delete', 'Artículo eliminado con éxito');
    }
}
