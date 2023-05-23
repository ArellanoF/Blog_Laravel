<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [
        'id', 'created_ad', 'updated_ad'];
    
    //Relacion entre de uno a muchos (categorias->articulos)
    public function articles(){
        return $this->hasMany(Article::class);
    }
}
