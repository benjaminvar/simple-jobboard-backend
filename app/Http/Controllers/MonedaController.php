<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Moneda;
class MonedaController extends Controller
{
    public function getAll()
	{
		$monedas = Moneda::all();
		return response()->json($monedas);
	}
}
