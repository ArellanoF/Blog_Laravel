@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h2>Administra tus categorías</h2>
@endsection

@section('content')
@if(session('success-create'))
<div class="alert alert-info">
    {{session('success-create')}}
</div>
@elseif(session('success-update'))
<div class="alert alert-info">
    {{session('success-update')}}
</div>
@elseif(session('success-delete'))
<div class="alert alert-info">
    {{session('success-delete')}}
</div>
@endif
<div class="card">

    @can('categories.create')
    <div class="card-header">
        <a class="btn btn-primary" href="{{route('categories.create')}}">Crear categoría</a>
    </div>
    @endcan
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Destacado</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ Str::limit($category->name, 25, '...') }}</td>
                    <td>
                        <input type="checkbox" name="status" id="status" class="form-check-input ml-3 " {{$category->status ? 'checked' : ''}} disabled>
                    </td>
                    <td>
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input ml-4" {{$category->is_featured ? 'checked' : ''}} disabled>
                    </td>

                    <td width="20px"><a href="{{route('categories.detail', $category->slug)}}" class="btn btn-primary btn-sm mb-2">Mostrar</a></td>
                    @can('categories.edit')
                    <td width="20px"><a href="{{route('categories.edit', $category->slug)}}" class="btn btn-primary btn-sm mb-2">Editar</a></td>
                    @endcan

                    @can('categories.destroy')
                    <td width="5px">
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal-{{ $category->id }}">Eliminar</button>
                        <div class="modal fade" id="confirmDeleteModal-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel-{{ $category->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $category->id }}">Confirmar Eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar esta categoría?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('categories.destroy', $category->slug) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endcan

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-3">
            {!! $categories->render() !!}
        </div>
    </div>
</div>
@endsection