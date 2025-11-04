<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Categoria;     // <-- importar modelo
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Obtenemos todos los productos ordenados por id descendente (últimos primero)
       // $productos = Producto::orderBy('id', 'desc')->paginate(10);

        //$productos = Producto::all();
         $productos = Producto::orderBy('id', 'desc')->take(10)->get();

        // Retornamos la vista pasando los productos
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Trae las categorías (ordenadas por nombre)
        $categorias = Categoria::orderBy('nombre')->get();
          // Pasa la variable a la vista
        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            //return response()->json($request->all());
        $request->validate([
        'categoria_id' => 'required|exists:categorias,id',
        'codigo' => 'required|unique:productos,codigo',
        'nombre' => 'required',
        'descripcion' => 'required',
        'imagen' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'precio_compra' => 'required|numeric',
        'precio_venta' => 'required|numeric',
        'stock_minimo' => 'required|integer',
        'stock_maximo' => 'required|integer',
        'unidad_medida' => 'required',
        'estado' => 'required|boolean'
    ]);

    $producto = new Producto();
    $producto->categoria_id = $request->categoria_id;
    $producto->codigo = $request->codigo;
    $producto->nombre = $request->nombre;
    $producto->descripcion = $request->descripcion;
    $producto->imagen = $request->file('imagen')->store('imagenes/productos', 'public');
    $producto->precio_compra = $request->precio_compra;
    $producto->precio_venta = $request->precio_venta;
    $producto->stock_minimo = $request->stock_minimo;
    $producto->stock_maximo = $request->stock_maximo;
    $producto->unidad_medida = $request->unidad_medida;
    $producto->estado = $request->estado;

    $producto->save();

    return redirect()
    ->route('productos.index')
    ->with('icono', 'success') // tipo del mensaje (success, error, warning, info)
    ->with('message', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto   = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'codigo'       => 'required',
            'nombre'       => 'required',
            'descripcion'  => 'required',
            'precio_compra'=> 'required|numeric',
            'precio_venta' => 'required|numeric',
            'stock_minimo' => 'required|integer',
            'stock_maximo' => 'required|integer',
            'unidad_medida'=> 'required',
            'estado'       => 'required|boolean',
            'imagen'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);
         return redirect()
        ->route('productos.index')
        ->with('icono', 'success')              // tipo de notificación
        ->with('message', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar el producto o lanzar 404
        $producto = Producto::findOrFail($id);

        // (Opcional) Si quieres eliminar la imagen del almacenamiento
        if ($producto->imagen) {
             Storage::disk('public')->delete($producto->imagen);
        }

        // Eliminar el registro
        $producto->delete();

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('productos.index')
            ->with('icono', 'success')
            ->with('message', 'Producto eliminado correctamente.');
    }
}
