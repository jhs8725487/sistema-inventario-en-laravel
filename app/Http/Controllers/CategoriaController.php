<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //echo "Hello good morning";
        $categorias = Categoria::all();

        //echo $categorias;

        // Retorna una vista y envía los datos
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         // 1️⃣ Validar los datos
    $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    // 2️⃣ Guardar en la base de datos

     // Crear nueva instancia
    $categoria = new Categoria();
    $categoria->nombre = $request->nombre;
    $categoria->descripcion = $request->descripcion;

    // Guardar en la base de datos
    $categoria->save();

    // 3️⃣ Redirigir con mensaje de éxito
    //return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');

    return redirect()
    ->route('categoria.index')
    ->with('icono', 'success')   // tipo del mensaje (success, error, warning, info)
    ->with('message', 'Categoría creada correctamente.');

    //echo "Se guardo correctamente";
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.show', compact('categoria'));
        //return response()->json($categoria);
        //echo $id;
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
           $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        return redirect()
    ->route('categoria.index')
    ->with('icono', 'success')   // tipo del mensaje (success, error, warning, info)
    ->with('message', 'Categoría actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
          // Buscar la categoría por ID, si no existe lanza error 404
        $categoria = Categoria::findOrFail($id);

        // Eliminar la categoría
        $categoria->delete();

        // Redirigir al listado con mensaje de éxito
          return redirect()
        ->route('categoria.index')
        ->with('icono', 'success')  // tipo de mensaje: success, error, warning, info
        ->with('message', 'Categoría eliminada correctamente.');
    }
}
