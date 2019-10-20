<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
class CategoriaController extends Controller
{
    /**
     * Obtiene todas las categorias y su total ofertas de trabajo
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $resultado = Categoria::selectRaw("categorias.id,categorias.nombre,count(ofertas.id) as `count`")
        ->join("ofertas","categorias.id","=","ofertas.categoria_id")
        ->groupBy(["categorias.id","categorias.nombre"])
        ->get();
        return response()->json($resultado);
    }
}
