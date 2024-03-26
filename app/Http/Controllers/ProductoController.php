<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductoController extends Controller
{
    public function index()
    {
        $response = Http::get($this->getPath('/producto'));

        $productos = null;
        if ($response->successful()) {
            $productos = $response->json();
        }

        return view('aplicacion.producto.producto', compact('productos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'integer',
            'codigo' => 'required|string|max:20',
            'nombre' => 'required|string|max:255',
            'precio_unitario' => 'required|string|max:255',
        ]);


        if ((int)$validatedData['id'] === 0) {
            $response = Http::post($this->getPath('/producto'), [
                'id' => $validatedData['id'],
                'codigo' => $validatedData['codigo'],
                'nombre' => $validatedData['nombre'],
                'precio_unitario' => $validatedData['precio_unitario'],
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Producto registrado exitosamente.');
            } else {
                return back()->withErrors(['message' => 'No se pudo registrar el producto en la API externa.']);
            }
        } else {
            $response = Http::put($this->getPath('/producto/') . $validatedData['id'], [
                'id' => $validatedData['id'],
                'codigo' => $validatedData['codigo'],
                'nombre' => $validatedData['nombre'],
                'precio_unitario' => $validatedData['precio_unitario'],
            ]);

            if ($response->successful()) {

                return back()->with('success', 'Producto actualizado exitosamente.');
            } else {

                return back()->withErrors(['message' => 'No se pudo actualizar el producto en la API externa.']);
            }
        }
    }

    public function destroy($id)
    {

        $response = Http::delete($this->getPath('/producto/') . $id);

        if ($response->successful()) {

            return redirect()->route('producto')->with('success', 'Producto eliminado correctamente.');
        } else {

            return back()->withErrors(['message' => 'No se pudo eliminar el producto desde la API externa']);
        }
    }
}
