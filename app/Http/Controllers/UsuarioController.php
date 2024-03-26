<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsuarioController extends Controller
{
    public function index()
    {
        $response = Http::get($this->getPath('/usuario'));

        $usuarios = null;
        if ($response->successful()) {
            $usuarios = $response->json();
        }

        return view('aplicacion.usuario.usuario', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'max:11',
            'nombre' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ((int)$validatedData['id'] === 0) {
            $response = Http::post($this->getPath('/usuario'), [
                'nombre' => $validatedData['nombre'],
                'usuario' => $validatedData['usuario'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Usuario registrado exitosamente.');
            } else {
                return back()->withErrors(['message' => 'No se pudo registrar el Usuario en la API externa.']);
            }
        } else {
            $response = Http::put($this->getPath('/usuario/') . $validatedData['id'], [
                'id' => $validatedData['id'],
                'nombre' => $validatedData['nombre'],
                'usuario' => $validatedData['usuario'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
            ]);

            if ($response->successful()) {

                return back()->with('success', 'Usuario actualizado exitosamente.');
            } else {

                return back()->withErrors(['message' => 'No se pudo actualizar el Usuario en la API externa.']);
            }
        }
    }

    public function destroy($id)
    {

        $response = Http::delete($this->getPath('/usuario/') . $id);

        if ($response->successful()) {

            return redirect()->route('usuario')->with('success', 'Usuario eliminado correctamente.');
        } else {

            return back()->withErrors(['message' => 'No se pudo eliminar el Usuario desde la API externa']);
        }
    }
}
