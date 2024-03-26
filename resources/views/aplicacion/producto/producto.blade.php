@extends('adminlte::page')

@section('title', 'Producto')

@section('content_header')
    <h1>Listado de Productos</h1>
@stop

@section('content')
    <div class="w-75 d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary registroProductoModal" data-toggle="modal"
            data-target="#registroProductoModal">
            Registrar Producto
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registroProductoModal" tabindex="-1" role="dialog" aria-labelledby="registroProductoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroProductoModalLabel">Formulario de Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('aplicacion.producto.producto') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="0">
                            <input type="text" class="form-control" id="codigo" name="codigo" value=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value=""
                                required>
                        </div>
                        <div class="form-group">
                            <label for="precio_unitario">Número de Documento</label>
                            <input type="number" class="form-control" step="0.01"
                                name="precio_unitario"id="precio_unitario" value="" required>
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
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Precio Unitario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($productos != null)
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto['id'] }}</td>
                                <td>{{ $producto['codigo'] }}</td>
                                <td>{{ $producto['nombre'] }}</td>
                                <td>{{ $producto['precio_unitario'] }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-primary editarProductoBtn" data-toggle="modal"
                                        data-target="#registroProductoModal"
                                        data-producto="{{ json_encode($producto) }}">Editar</button>
                                    <button type="button" class="btn btn-danger eliminarProductoBtn"
                                        data-producto-id="{{ $producto['id'] }}">Eliminar</button>
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
            $('.editarProductoBtn').click(function() {
                var producto = $(this).data('producto');
                $('#registroProductoModal input[name="id"]').val(producto.id);
                $('#registroProductoModal input[name="codigo"]').val(producto.codigo);
                $('#registroProductoModal input[name="nombre"]').val(producto.nombre);
                $('#registroProductoModal input[name="precio_unitario"]').val(producto.precio_unitario);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.registroProductoModal').click(function() {
                $('#registroProductoModal input[name="id"]').val(0);
                $('#registroProductoModal input[name="codigo"]').val('');
                $('#registroProductoModal input[name="nombre"]').val('');
                $('#registroProductoModal input[name="precio_unitario"]').val('');
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.eliminarProductoBtn').click(function() {

                var productoId = $(this).data('producto-id');

                if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {

                    fetch('/productos/' + productoId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error al eliminar el producto');
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
