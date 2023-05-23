<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [
    'id', 'created_ad', 'updated_ad'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function article(){
        return $this->belongsToMany(Article::class);
    }

}
