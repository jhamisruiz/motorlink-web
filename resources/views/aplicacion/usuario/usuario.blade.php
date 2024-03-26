@extends('adminlte::page')

@section('title', 'Usuario')

@section('content_header')
    <h1>Listado de Usuario</h1>
@stop

@section('content')
    <div class="w-75 d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary registroUsuarioModal" data-toggle="modal"
            data-target="#registroUsuarioModal">
            Registrar Usuario
        </button>
    </div>
    <div class="modal fade" id="registroUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="registroUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroUsuarioModalLabel">Formulario de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('aplicacion.usuario.usuario') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="0">
                            <input type="text" class="form-control" id="nombre" name="nombre" value=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" value=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password" value=""
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Email verified</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($usuarios != null)
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario['id'] }}</td>
                                <td>{{ $usuario['nombre'] }}</td>
                                <td>{{ $usuario['usuario'] }}</td>
                                <td>{{ $usuario['email'] ?? '0' }}</td>
                                <td>{{ $usuario['email_verified_at'] ?? '0' }}</td>
                                <td>{{ $usuario['created_at'] ?? '0' }}</td>
                                <td>{{ $usuario['updated_at'] ?? '0' }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-primary editarUsuarioBtn" data-toggle="modal"
                                        data-target="#registroUsuarioModal"
                                        data-usuario="{{ json_encode($usuario) }}">Editar</button>
                                    <button type="button" class="btn btn-danger eliminarUsuarioBtn"
                                        data-usuario-id="{{ $usuario['id'] }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <p class="w-100 text-center"><b>No data!</b></p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.editarUsuarioBtn').click(function() {
                var usuario = $(this).data('usuario');
                $('#registroUsuarioModal input[name="id"]').val(usuario.id);
                $('#registroUsuarioModal input[name="nombre"]').val(usuario.nombre);
                $('#registroUsuarioModal input[name="usuario"]').val(usuario.usuario);
                $('#registroUsuarioModal input[name="email"]').val(usuario.email);
                $('#registroUsuarioModal input[name="password"]').val(usuario.password);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.registroUsuarioModal').click(function() {
                $('#registroUsuarioModal input[name="id"]').val(0);
                $('#registroUsuarioModal input[name="nombre"]').val('');
                $('#registroUsuarioModal input[name="usuario"]').val('');
                $('#registroUsuarioModal input[name="email"]').val('');
                $('#registroUsuarioModal input[name="password"]').val('');
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.eliminarUsuarioBtn').click(function() {

                var userId = $(this).data('usuario-id');

                if (confirm("¿Estás seguro de que deseas eliminar este Usuario?")) {

                    fetch('/usuarios/' + userId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error al eliminar el usuario');
                            }

                            window.location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                            window.location.reload();
                        });
                }
            });
        });
    </script>
@stop
