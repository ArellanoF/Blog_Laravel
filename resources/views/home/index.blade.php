@extends('layouts.base');

@section('styles')
<link rel="stylesheet" href="{{asset('css/manage-_post/categories/css/article_category.css')}}" class="css">
@endsection
@section('title', 'Blog Categories')
@section('content')
@include('layouts.navbar')
<div class="slogan">
    <div class="column1">
        <h2>BLOG</h2>
    </div>
    <div class="column2">
        <p>Hemos ayudado a más de 1 millon de personas a crecer 
           profesionalmente. Estos artículos comparten concejos
           para la búsqueda de empleo, la productividad y el éxito 
           laboral en diferentes áreas del conocimiento.</p>
    </div>
</div>

<div class="article-container">
    <!-- Listar artículos -->
    <article class="article">
        <img src="" class="img">
        <div class="card-body">
            <a href="#">
                <h2 class="title"></h2>
            </a>
            <p class="introduction"></p>
        </div>
    </article>
</div>
<div class="links-paginate">
    
</div>
@endsection