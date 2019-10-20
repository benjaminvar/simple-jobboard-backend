<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;
class EstadoController extends Controller
{
    /**
     * Obtiene todos los estados/provincias
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        $estados = Estado::all();
        return response()->json($estados,200);
    }
}
