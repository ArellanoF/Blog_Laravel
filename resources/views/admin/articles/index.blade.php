@extends('adminlte::page')

@section('title', 'Panel de administración')

@section('content_header')
<h2>Administra tus artículos</h2>
@stop 

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
    <div class="card-header">
        <a class="btn btn-primary" href="{{route('articles.create')}}">Crear artículo</a>
    </div>

    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ Str::limit($article->title, 25, '...') }}</td>
                    <td>{{ $article->category->name }}</td>
                    <td>
                        <input type="checkbox" name="status" id="status" class="form-check-input ml-4"
                        {{ $article->status ? 'checked=checked"' : '' }}
                        disabled>
                    </td>

                    <td width="2px"><a href="{{route('articles.show', $article->slug)}}"
                            class="btn btn-primary btn-sm mb-2">Mostrar</a></td>

                    <td width="5px"><a href="{{route('articles.edit', $article->slug)}}"
                            class="btn btn-primary btn-sm mb-2">Editar</a></td>

                    <td width="5px">
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal">Eliminar</button>
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este artículo?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form action="{{ route('articles.destroy', $article->slug) }}" method="POST">
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
        </table>
        <div class="text-center mt-3">
            {!! $articles->render() !!}
        </div>
    </div>
</div>
@stop

<!-- <script>
    function confirmDelete() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("delete-form").submit();
            }
        });
    }
</script> -->
<!-- @section('js')
<script>
    function confirmDelete() {
        if (confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
            document.getElementById("delete-form").submit();
        } else {
            return false;
        }
    }
</script>
@endsection -->