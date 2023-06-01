<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //mostrar categorias en el admin
        $categories = Category::orderBy('id', 'desc')
        ->simplePaginate(8);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $request->all();

        //validar si hay archivo
        if($request->hasFile('image')){
            $category['image'] = $request->file('image')->store('categories');
           }
    
           Category::create($category);
    
           return redirect()->action([CategoryController::class, 'index'])
           ->with('success-create', 'Categoria creada con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
       return view ('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //si el usuario sube una nueva imagen
        if($request->hasFile('image')){
            //Eliminar la imagen anterior
            File::delete(public_path('storage/' . $category->image));
            //asignar nueva imagen
            $category['image'] = $request->file('image')->store('categories');
        }

        //Actualizar datos
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'is_featured' => $request->is_featured,
            'status' => $request->status
        ]);

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
        ->with('success-update', 'Categoria actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
       // Guardar la ruta de la imagen antes de eliminar la ctaegoria
       $imagePath = public_path('storage/' . $category->image);
       if ($category->delete()) {
           if ($category->image && File::exists($imagePath)) {
               File::delete($imagePath);
           }
       }

       return redirect()->action([CategoryController::class, 'index'], compact ('category'))
       ->with('success-delete', 'Categoria eliminada con éxito');
    }

    //filtrar articulos por categorias
    public function detail(Category $category){
        
        $this->authorize('published', $category);
        
        $articles = Article::where([
            ['category_id' , $category->id],
            ['status' , 1]
        ])
        ->orderBy('id', 'desc')
        ->simplePaginate(5);

         #Obtener las categorias publicos(1) y destacadas (1)
         $navbar = Category::where([
            ['status', 1],
            ['is_featured', 1],
        ])->paginate(3);

        return view('subscriber.categories.detail', compact('articles', 'category', 'navbar'));
    }
}
 