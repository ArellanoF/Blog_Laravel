<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [
        'id', 'created_ad', 'updated_ad'];
    
     //Relación de uno a muchos inversa (article-users)
     public function user(){
        return $this->belongsTo(User::class);
    }

    //Relación de uno a muchos con comentarios
    public function comments(){
        return $this->hasMany(Comment::class);
    }

     //Relación de uno a muchos inversa (categoria - articulos)
     public function category(){
        return $this->belongsTo(Category::class);
    }

    #Utilizar slug en lugar de id
    public function getRouteKeyName(){
        return 'slug';
    }
}
