<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    public function index()
    {

        $response = Http::get($this->getPath('/cliente'));

        $clientes = null;
        if ($response->successful()) {
            $clientes = $response->json();
        }

        return view('aplicacion.cliente.cliente', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'max:11',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'numero_documento' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
        ]);


        if ((int)$validatedData['id'] === 0) {
            $response = Http::post($this->getPath('/cliente'), [
                'nombre' => $validatedData['nombre'],
                'apellido' => $validatedData['apellido'],
                'numero_documento' => $validatedData['numero_documento'],
                'telefono' => $validatedData['telefono'],
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Cliente registrado exitosamente.');
            } else {
                return back()->withErrors(['message' => 'No se pudo registrar el cliente en la API externa.']);
            }
        } else {
            $response = Http::put($this->getPath('/cliente/') . $validatedData['id'], [
                'id' => $validatedData['id'],
                'nombre' => $validatedData['nombre'],
                'apellido' => $validatedData['apellido'],
                'numero_documento' => $validatedData['numero_documento'],
                'telefono' => $validatedData['telefono'],
            ]);

            if ($response->successful()) {

                return back()->with('success', 'Cliente actualizado exitosamente.');
            } else {

                return back()->withErrors(['message' => 'No se pudo actualizar el cliente en la API externa.']);
            }
        }
    }

    public function destroy($id)
    {

        $response = Http::delete($this->getPath('/cliente/') . $id);

        if ($response->successful()) {

            return redirect()->route('cliente')->with('success', 'Cliente eliminado correctamente.');
        } else {

            return back()->withErrors(['message' => 'No se pudo eliminar el cliente desde la API externa']);
        }
    }
}
