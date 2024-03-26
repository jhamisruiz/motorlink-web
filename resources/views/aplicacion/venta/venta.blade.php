@extends('adminlte::page')

@section('title', 'Venta')

@section('content_header')
    <h1>Venta</h1>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"
        integrity="sha512-7oYXeK0OxTFxndh0erL8FsjGvrl2VMDor6fVqzlLGfwOQQqTbYsGPv4ZZ15QHfSk80doyaM0ZJdvkyDcVO7KFA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular-csp.min.css"
        integrity="sha512-nptw3cPhphu13Dy21CXMS1ceuSy2yxpKswAfZ7bAAE2Lvh8rHXhQFOjU+sSnw4B+mEoQmKFLKOj8lmXKVk3gow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
        integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g=="
        crossorigin="anonymous" />

    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/angular-input-masks/4.4.1/angular-input-masks-standalone.min.js">
    </script>
@stop

@section('content')
    <!-- Agrega esto en tu layout o en una vista específica -->
    <div class="w-75 d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary registroVentaModal" data-toggle="modal"
            data-target="#registroVentaModal">
            Registrar Venta
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registroVentaModal" tabindex="-1" role="dialog" aria-labelledby="registroVentaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content " ng-app="myApp" ng-controller="formController">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroVentaModalLabel">Formulario de Ventas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group d-none">
                            <label for="nombre">Id</label>
                            <input type="hidden" class="form-control" id="id" ng-model="formData.id" value="0">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id_cliente">Cliente</label>
                                    <select class="form-control" id="id_cliente" ng-model="formData.id_cliente">
                                        <option value="">Selecciona un cliente</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente['id'] }}">{{ $cliente['nombre'] }}
                                                {{ $cliente['apellido'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-none">
                                    <label for="id_usuario">ID Usuario </label>

                                    <input type="number" class="form-control" id="id_usuario"
                                        ng-model="formData.id_usuario">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="precio_total">Precio Total</label>
                                    <input type="number" step="0.01" class="form-control" id="precio_total"
                                        ng-model="formData.precio_total">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_venta">Fecha de Venta</label>
                                    <input type="date" class="form-control" id="fecha_venta"
                                        ng-model="formData.fecha_venta">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Detalles de Venta</h3>
                            </div>
                            <select class="form-control" ng-model="selectedOption"
                                ng-change="handleChange({{ Auth::user()->id }})">
                                <option value="">Selecciona un producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ json_encode($producto) }}" class="d-flex">
                                        <div class="mr-4">
                                            {{ $producto['nombre'] }}
                                        </div>-
                                        <div class="ml-4">
                                            S/. {{ $producto['precio_unitario'] }}
                                        </div>
                                    </option>
                                @endforeach
                            </select>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalleBody">
                                        <tr ng-repeat="(index,prod) in formData.venta_detalle">
                                            <td>{[index+1]}</td>
                                            <td>{[prod.nombre]}</td>
                                            <td>S/ {[prod.precio]}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- {[formData]} --}}
                        <button type="button" ng-click="submitForm();" class="btn btn-primary">Guardar</button>
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
                        <th>Cliente</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>fecha_venta</th>
                        <th>fecha_creacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ventas != null)
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>{{ $venta['id'] }}</td>
                                <td>
                                    @if ($clientes != null)
                                        @foreach ($clientes as $cliente)
                                            @if ($venta['id_cliente'] === $cliente['id'])
                                                <br>
                                                {{ $cliente['nombre'] }}
                                                <br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if ($usuarios != null)
                                        @foreach ($usuarios as $usuario)
                                            @if ($venta['id_cliente'] === $usuario['id'])
                                                <br>
                                                {{ $usuario['nombre'] }}
                                                <br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $venta['precio_total'] }}</td>
                                <td>{{ $venta['fecha_venta'] }}</td>
                                <td>{{ $venta['fecha_creacion'] }}</td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-primary editarVentaBtn" data-toggle="modal"
                                        data-target="#registroVentaModal"
                                        data-venta="{{ json_encode($venta) }}">Editar</button>
                                    <button type="button" class="btn btn-danger eliminarVentaBtn"
                                        data-venta-id="{{ $venta['id'] }}">Eliminar</button>
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
        var app = angular.module('myApp', []);
        app.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('{[').endSymbol(']}');
        });
        app.controller('formController', function($scope, $http) {

            $scope.handleChange = function(id_user) {
                if ($scope.formData.venta_detalle.indexOf($scope.selectedOption) === -1) {
                    var producto = JSON.parse($scope.selectedOption);

                    $scope.formData.venta_detalle.push({
                        id: 0,
                        id_venta: 0,
                        id_producto: producto.id,
                        nombre: producto.nombre,
                        precio: producto.precio_unitario,
                    });
                    $scope.formData.id_usuario = id_user;
                }

            };

            $scope.formData = {
                id: 0,
                venta_detalle: [],
                id_usuario: 0,
            };

            $scope.submitForm = function() {
                console.log($scope.formData);
                $scope.formData.venta_detalle = [{
                    id: 0,
                    id_venta: 0,
                    id_producto: 1
                }]
                $http({
                    method: 'POST',
                    url: '/ventas',
                    data: JSON.stringify($scope.formData),
                    headers: {
                        'Content-Type': undefined
                    }
                }).then(function success(response) {
                        console.log('Respuesta del servidor:', response.data);
                    },
                    function error(response) {
                        console.log('error del servidor:', response);
                    }
                );
            };
        });
    </script>

@stop
