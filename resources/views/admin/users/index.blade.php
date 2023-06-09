@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<h1>Lista de usuarios</h1>
@endsection

@section('content')

@if(session('succes-delete'))
<div class="alert alert-info">
    {{session('succes-delete')}}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre completo</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <td>{{$user->full_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @foreach($user->roles as $role)
                        {{$role->name}}
                        @endforeach
                    </td>
                    <td width="10px">
                        <a href="{{route('users.edit', $user)}}" class="btn btn-primary btn-sm mb-2">Editar</a>
                    </td>
                    <td width="10px">
                        <form action="{{ route('users.destroy', $user) }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal">Eliminar</button>
                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar este usuario?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
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
            {!! $users->render() !!}
        </div>

    </div>
</div>
@endsection