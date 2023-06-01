@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h2>Administra los comentarios</h2>
@endsection

@section('content')

@if(session('success-delete'))
<div class="alert alert-info">
    {{session('success-delete')}}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título del artículo</th>
                    <th>Calificación &#11088; </th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td>{{$comment->title}}</td>
                    <td>{{$comment->value}}</td>
                    <td>{{Str::limit($comment->description, 50, '...')}}</td>
                    <td>{{$comment->full_name}}</td>


                    <td width="10px">
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal-{{ $comment->id }}">Eliminar</button>
                        <div class="modal fade" id="confirmDeleteModal-{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel-{{ $comment->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $comment->id }}">Confirmar Eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar este comentario?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </div>
</div>
@endsection