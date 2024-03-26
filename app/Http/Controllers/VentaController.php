<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VentaController extends Controller
{
    public function index()
    {
        $res_ventas = Http::get($this->getPath('/venta'));
        $res_clientes = Http::get($this->getPath('/cliente'));
        $res_usuarios = Http::get($this->getPath('/usuario'));
        $res_productos = Http::get($this->getPath('/producto'));

        $ventas = null;
        if ($res_ventas->successful()) {
            $ventas = $res_ventas->json();
        }

        $clientes = null;
        if ($res_clientes->successful()) {
            $clientes = $res_clientes->json();
        }

        $usuarios = null;
        if ($res_usuarios->successful()) {
            $usuarios = $res_usuarios->json();
        }

        $productos = null;
        if ($res_productos->successful()) {
            $productos = $res_productos->json();
        }

        $sesion = Auth::user();

        return view('aplicacion.venta.venta', compact('ventas', 'clientes', 'usuarios', 'productos', 'sesion'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'max:11',
            'id_cliente' => 'max:11',
            'id_usuario' => 'max:11',
            'precio_total' => 'max:11',
            'fecha_venta' => 'max:100',
            'venta_detalle' => '',
        ]);

        $response = Http::post($this->getPath('/venta'), [
            'id_cliente' => (int)$validatedData['id_cliente'],
            'id_usuario' => $validatedData['id_usuario'],
            'precio_total' => $validatedData['precio_total'],
            'fecha_venta' => $validatedData['fecha_venta'],
            'venta_detalle' => $validatedData['venta_detalle'],
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Venta registrado exitosamente.');
        } else {
            return back()->withErrors(['message' => 'No se pudo registrar el Venta en la API externa.']);
        }
        // if ((int)$validatedData['id'] === 0) {
        //     $response = Http::post($this->getPath('/venta'), [
        //         'id_cliente' => $validatedData['id_cliente'],
        //         'id_usuario' => $validatedData['id_usuario'],
        //         'precio_total' => $validatedData['precio_total'],
        //         'fecha_venta' => $validatedData['fecha_venta'],
        //         'venta_detalle' => $validatedData['venta_detalle'],
        //     ]);

        //     if ($response->successful()) {
        //         return back()->with('success', 'Venta registrado exitosamente.');
        //     } else {
        //         return back()->withErrors(['message' => 'No se pudo registrar el Venta en la API externa.']);
        //     }
        // } else {
        //     $response = Http::put($this->getPath('/venta/') . $validatedData['id'], [
        //         'id' => $validatedData['id'],
        //         'nombre' => $validatedData['nombre'],
        //         'usuario' => $validatedData['usuario'],
        //         'email' => $validatedData['email'],
        //         'password' => $validatedData['password'],
        //     ]);

        //     if ($response->successful()) {

        //         return back()->with('success', 'Usuario actualizado exitosamente.');
        //     } else {

        //         return back()->withErrors(['message' => 'No se pudo actualizar el Usuario en la API externa.']);
        //     }
        // }
    }

    public function destroy($id)
    {

        $response = Http::delete($this->getPath('/venta/') . $id);

        if ($response->successful()) {

            return redirect()->route('venta')->with('success', 'venta eliminado correctamente.');
        } else {

            return back()->withErrors(['message' => 'No se pudo eliminar el venta desde la API externa']);
        }
    }
}
