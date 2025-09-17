<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         // Obtenemos todas las sucursales ordenadas por id descendente (últimas primero)
        $sucursales = Sucursal::orderBy('id', 'desc')->paginate(10);

        // Retornamos la vista pasando las sucursales
        return view('admin.sucursales.index', compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sucursales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           // 1️⃣ Validar los datos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'activa' => 'required|boolean',
    ]);

    // 2️⃣ Guardar en la base de datos
    $sucursal = new Sucursal();
    $sucursal->nombre = $request->nombre;
    $sucursal->direccion = $request->direccion;
    $sucursal->telefono = $request->telefono;
    $sucursal->email = $request->email;
    $sucursal->activa = $request->activa;
    $sucursal->save();

    // 3️⃣ Redirigir con mensaje de éxito
    return redirect()
        ->route('sucursal.index')
        ->with('icono', 'success') // tipo del mensaje (success, error, warning, info)
        ->with('message', 'Sucursal creada correctamente.');

    // Para prueba en JSON (opcional)
        //return response()->json($sucursal);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
            // 1️⃣ Buscar la sucursal por ID (o lanzar error 404 si no existe)
        $sucursal = Sucursal::findOrFail($id);

        // 2️⃣ Retornar la vista con los datos
        return view('admin.sucursales.show', compact('sucursal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
            
            // 1️⃣ Buscar la sucursal por ID (si no existe lanza 404)
        $sucursal = Sucursal::findOrFail($id);

        // 2️⃣ Retornar la vista edit con los datos
        return view('admin.sucursales.edit', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         // 1️⃣ Validar los datos
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'activa' => 'required|boolean',
    ], [
        'nombre.required' => 'El nombre de la sucursal es obligatorio.',
        'direccion.required' => 'La dirección es obligatoria.',
        'email.email' => 'El correo electrónico no tiene un formato válido.',
        'activa.required' => 'Debe indicar si la sucursal está activa o no.',
    ]);

    // 2️⃣ Buscar la sucursal
    $sucursal = Sucursal::findOrFail($id);

    // 3️⃣ Actualizar los datos
    $sucursal->update($validated);

    // 4️⃣ Redirigir con mensaje de éxito
    return redirect()
        ->route('sucursal.index')
        ->with('icono', 'success')
        ->with('message', 'Sucursal actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            // 1️⃣ Buscar la sucursal
        $sucursal = Sucursal::findOrFail($id);

        // 2️⃣ Eliminarla de la base de datos
        $sucursal->delete();

        // 3️⃣ Redirigir con mensaje de éxito
        return redirect()
            ->route('sucursal.index')
            ->with('icono', 'success')
            ->with('message', 'Sucursal eliminada correctamente.');
        }
}
