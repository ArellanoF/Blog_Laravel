<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //mostrar comentarios en el admin
         $comments = DB::table('comments')
         ->join('articles', 'comments.article_id', '=', 'articles.id')
         ->join('users', 'comments.user_id', '=', 'users.id')
         ->select('comments.id','comments.value', 'comments.description', 
         'articles.title', 'users.full_name')
         ->orderBy('articles.id', 'desc')
         ->get();
 
         return view('admin.comments.index', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
      
    $result = Comment::where('user_id', Auth::user()->id)
                        ->where('article_id', $request->article_id)->exists();
    
    //Consulta para obtener el slug estado del articulo comentado
    $article = Article::select('status', 'slug')->find($request->article_id);
   
    if (!$result && $article->status == 1) {
        Comment::create([
            'value' => $request->value,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'article_id' => $request->article_id
        ]);
       
        return redirect()->action([ArticleController::class, 'show'], [$article->slug]);
    }else{
        return redirect()->action([ArticleController::class, 'show'], [$article->slug])
        ->with('success-error', 'Solo puedes comentar una vez');
    }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->action([CommentController::class, 'index'], compact('comment'))
        ->with('success-delete', 'Comentario eliminado correctamente');
        
    }
}
