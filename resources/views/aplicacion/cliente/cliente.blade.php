@extends('adminlte::page')

@section('title', 'Cliente')

@section('content_header')
    <h1>Listado de Clientes</h1>
@stop

@section('content')

    <div class="w-75 d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary registroClienteModal" data-toggle="modal"
            data-target="#registroClienteModal">
            Registrar Cliente
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registroClienteModal" tabindex="-1" role="dialog" aria-labelledby="registroClienteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroClienteModalLabel">Formulario de Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('aplicacion.cliente.cliente') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="0">
                            <input type="text" class="form-control" id="nombre" name="nombre" value=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="numero_documento">Número de Documento</label>
                            <input type="text" class="form-control" id="numero_documento" name="numero_documento"
                                value="" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value=""
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
                        <th>Apellido</th>
                        <th>Número de Documento</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($clientes != null)
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente['id'] }}</td>
                                <td>{{ $cliente['nombre'] }}</td>
                                <td>{{ $cliente['apellido'] }}</td>
                                <td>{{ $cliente['numero_documento'] }}</td>
                                <td>{{ $cliente['telefono'] }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-primary editarClienteBtn" data-toggle="modal"
                                        data-target="#registroClienteModal"
                                        data-cliente="{{ json_encode($cliente) }}">Editar</button>
                                    <button type="button" class="btn btn-danger eliminarClienteBtn"
                                        data-cliente-id="{{ $cliente['id'] }}">Eliminar</button>
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
            $('.editarClienteBtn').click(function() {
                var cliente = $(this).data('cliente');
                $('#registroClienteModal input[name="id"]').val(cliente.id);
                $('#registroClienteModal input[name="nombre"]').val(cliente.nombre);
                $('#registroClienteModal input[name="apellido"]').val(cliente.apellido);
                $('#registroClienteModal input[name="numero_documento"]').val(cliente.numero_documento);
                $('#registroClienteModal input[name="telefono"]').val(cliente.telefono);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.registroClienteModal').click(function() {
                $('#registroClienteModal input[name="id"]').val(0);
                $('#registroClienteModal input[name="nombre"]').val('');
                $('#registroClienteModal input[name="apellido"]').val('');
                $('#registroClienteModal input[name="numero_documento"]').val('');
                $('#registroClienteModal input[name="telefono"]').val('');
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.eliminarClienteBtn').click(function() {

                var clienteId = $(this).data('cliente-id');

                if (confirm("¿Estás seguro de que deseas eliminar este cliente?")) {

                    fetch('/clientes/' + clienteId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error al eliminar el cliente');
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
