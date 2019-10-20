<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Aplicacion;
use Storage;
use Auth;
class ArchivoController extends Controller
{
    /**
     * Obtiene el archivo de imagen del logo de la empresa
     * 
     * @param \App\User $user
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function getUserImage(User $user, Request $request)
    {
      
        return Storage::response($user->logo->url);
    }
    /**
     * Obtiene el curriculum de una aplicacion para previsualizar
     * 
     * @param \App\Aplicacion $aplicacion
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function getCV(Aplicacion $aplicacion,Request $request)
    {
        if($aplicacion->oferta->empresa->id !== Auth::user()->id)
        {
            return response()->json(["message" => "error"],404);
        }
        
        return Storage::response($aplicacion->hoja->url);
    }
     /**
     * Obtiene el curriculum de una aplicacion para descargar
     * 
     * @param \App\Aplicacion $aplicacion
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function downloadCV(Aplicacion $aplicacion,Request $request)
    {
        if($aplicacion->oferta->empresa->id !== Auth::user()->id)
        {
            return response()->json(["message" => "error"],404);
        }
        return Storage::download($aplicacion->hoja->url);
    }
}
