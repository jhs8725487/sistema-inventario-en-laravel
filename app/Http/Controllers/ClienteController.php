<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos todos los clientes
        $clientes = Cliente::all();

        // Retornamos la vista con los datos
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'ci'        => 'required|unique:clientes,ci|max:20',
            'nombre'    => 'required|max:100',
            'apellido'  => 'required|max:100',
            'telefono'  => 'nullable|max:20',
            'email'     => 'nullable|email|max:100',
            'direccion' => 'nullable|max:255',
            'activo'    => 'required|boolean',
        ]);

        // Crear el cliente
        $cliente = new \App\Models\Cliente();
        $cliente->ci        = $request->ci;
        $cliente->nombre    = $request->nombre;
        $cliente->apellido  = $request->apellido;
        $cliente->telefono  = $request->telefono;
        $cliente->email     = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->activo    = $request->activo;
        $cliente->save();

         // Redireccionar con mensaje tipo SweetAlert
    return redirect()
        ->route('clientes.index')
        ->with('icono', 'success')  // success, error, warning, info
        ->with('message', 'Cliente creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar datos
        $validated = $request->validate([
            'ci'        => 'required|string|max:50',
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'required|string|max:100',
            'telefono'  => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:150',
            'direccion' => 'nullable|string|max:255',
            'activo'    => 'required|boolean',
        ]);

        // Buscar cliente
        $cliente = Cliente::findOrFail($id);

        // Actualizar datos
        $cliente->update($validated);

        // Redirigir con mensaje y tipo de icono
        return redirect()
            ->route('clientes.index')  
            ->with('icono', 'success')
            ->with('message', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1️⃣ Buscar el cliente o lanzar 404 si no existe
        $cliente = Cliente::findOrFail($id);

        // 2️⃣ Eliminar el registro
        $cliente->delete();

        // 3️⃣ Redirigir con mensaje de éxito
        return redirect()->route('clientes.index')
            ->with('icono', 'success')
            ->with('message', 'Cliente eliminado correctamente.');
    }
}
