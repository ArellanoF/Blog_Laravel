<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $articles = Article::where([
            ['user_id', $profile->id],
            ['status', 1]
        ])->simplePaginate(8);

        return view('subscriber.profiles.show', compact('profile', 'articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
         return view ('subscriber.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $user = Auth::user();
        
        if($request->hasFile('photo')){
            //Eliminar foto anterior
            File::delete(public_path('storage/' . $profile->photo));

            //asignar nueva foto
            $photo = $request['photo']->store('profiles');
        }else{
            $photo = $user->profile->photo;
        }

        //ASIGNR NOMBRE Y CORREO
        
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        //Asignar campos adicionales 
        $user->profile->profession = $request->profession;
        $user->profile->about = $request->about;
        $user->profile->photo = $photo;
        $user->profile->twitter = $request->twitter;
        $user->profile->linkedin = $request->linkedin;
        $user->profile->facebook = $request->facebook; 

        //guardar campos de usuario
        $user->save();

        //asignar photo
        $user->profile->photo = $photo;

        //guardar campos de profile
        $user->profile->save();

        return redirect()->route('profiles.edit', $user->profile->id);
    }

}
