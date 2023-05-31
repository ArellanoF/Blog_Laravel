<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Crear un perfil cuando se crea un usuario

    protected static function boot(){
        parent::boot();

        static::created(function($user){
            $user->profile()->create();
        });
    }

    //Relacion de una a unu user->profile
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    //Relacion de una a muchos user->articulos
    public function articles(){
        return $this->hasMany(Article::class);
    }

    //Relacion de una a muchos user->comentarios
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function adminlte_image(){
        return asset('storage/' . Auth::user()->profile->photo );
    }
}
