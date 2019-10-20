<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aplicacion;
use App\Oferta;
use App\Archivo;
use Storage;
use File;
use Auth;
use \Illuminate\Database\Eloquent\Builder;
class AplicacionController extends Controller
{
    /**
     * Obtiene una aplicacion perteneciente una oferta para una empresa
     * 
     * @param \App\Aplicacion $aplicacion
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Aplicacion $aplicacion, Request $request)
    {
        if($aplicacion->oferta->empresa->id !== Auth::user()->id)
        {
            return response()->json(["message" => "error"],404);
        }
        return response()->json($aplicacion);
    }

    
    /**
     * Obtiene una aplicacion perteneciente una oferta para una empresa
     * 
     * @param \App\Aplicacion $aplicacion
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $page_number = $this->getDefaultPageNumber();
        $resultado = Auth::user()
        ->aplicaciones()
        ->where([
            ["nombre","like","%$request->keyword%"],
            ["apellido","like","%$request->keyword%"]
            ])
            ->whereHas("oferta",function(Builder $query) use($request){
                return $query->where("titulo","like","%$request->keyword%");
            })
        ->paginate($page_number);
        return response()->json($resultado);
    }

     /**
     * Guarda una aplicacion para una oferta de trabajo
     * 
     * @param \App\Oferta $oferta
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Oferta $oferta,Request $request)
    {
       
      
        $this->validateAplicacion($request);
        $archivo = new Archivo();
        $aplicacion = new Aplicacion();

        if($request->hasFile("hoja_vida"))
        {
            
            $hoja_vida = $request->file("hoja_vida");
            $nombre = $hoja_vida->getClientOriginalName();
            $tipo = $hoja_vida->getMimeType();
            $path = \Storage::putFile('files', $hoja_vida);
            $archivo->nombre = File::basename($path);
            $archivo->nombre_original = $nombre;
            $archivo->tipo = $tipo;
            $archivo->url = $path;
            $archivo->save();
       
        }
        
        $aplicacion->nombre = $request->nombre;
        $aplicacion->apellido = $request->apellido;
        $aplicacion->profesion =$request->profesion;
        $aplicacion->descripcion = $request->descripcion;
        $aplicacion->telefono = $request->telefono;
        $aplicacion->direccion = $request->direccion;
        $aplicacion->hoja_vida = $archivo->id;
        $aplicacion->oferta_id = $oferta->id;

        $aplicacion->save();
        $resultado = array("message" => "Registro guardado","success" => true);
        return response()->json($resultado);
       
    }
    /**
     * Valida los datos del formulario de aplicacion
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateAplicacion(Request $request)
    {
        $request->validate(
            [
                "nombre" => "required|string",
                "apellido" => "required|string",
                "profesion" => "required|string",
                "telefono" => "required",
                "direccion" => "required|string",
                "descripcion" => "required|string",
                "hoja_vida" => "required|file|mimes:doc,docx,pdf|max:5120"
            ]
        );
    }

     /**
     * Obtiene el numero maximo de resultados por pagina
     * 
     * @return int
     */
   private function getDefaultPageNumber()
   {
       return 25;
   }
}
