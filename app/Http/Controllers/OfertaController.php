<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oferta;
use Auth;
class OfertaController extends Controller
{
    /** 
     * Obtiene una oferta de trabajo
     * 
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function get($id, Request $request)
    {
        $oferta = Oferta::findOrFail($id);
        return response()->json($oferta);
    }
    /**
     * Obtiene todas las ofertas de trabajo
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function getAll(Request $request)
   {
       $page_number = $this->getDefaultPageNumber();
        if($request->has("page_number"))
        {
            $page_number = is_numeric($request->page_number) ?  $request->page_number : $page_number;
        }
        $ofertas = Oferta::orderBy("created_at","desc")->paginate($page_number);
       return response()->json($ofertas);
   }
   /**
     * Busca y devuelve las ofertas de trabajo por uno de los siguientes campos: titulo, categoria y estado/provincia.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function search(Request $request)
   {
       $page_number = $this->getDefaultPageNumber();
       $oferta = null;
        if($request->has("page_number"))
        {
            $page_number = is_numeric($request->page_number) ?  $request->page_number : $page_number;
        }
        if($request->has("titulo"))
        {
            if(is_null($oferta))
            {
                $oferta = Oferta::where("titulo","like","%".$request->titulo."%");
            }else{
                $oferta->where("titulo","like","%".$request->titulo."%");
            }
            
        }
        if($request->has("categoria")  && !empty($request->categoria))
        {
            if(is_null($oferta))
            {
                $oferta = Oferta::where("categoria_id",$request->categoria);
            }else{
                $oferta->where("categoria_id",$request->categoria);
            }
            
        }
        if($request->has("estado") && !empty($request->estado))
        {
            if(is_null($oferta))
            {
                $oferta = Oferta::where("estado",$request->estado);
            }else{
                $oferta->where("estado",$request->estado);
            }
            
        }
        if(is_null($oferta))
        {
            $resultados = Oferta::orderBy("created_at","desc")->paginate($page_number);
        }else{
            $resultados = $oferta->orderBy("created_at","desc")->paginate($page_number);
        }
       return response()->json($resultados);
   }
   /**
    * Guarda una oferta de trabajo nueva
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
    */
   public function create(Request $request)
    {
        $this->validateOffer($request);
        $oferta = new Oferta();
        $oferta->titulo = $request->titulo;
        $oferta->tipo = $request->tipo;
        $oferta->categoria_id = $request->categoria;
        $oferta->descripcion = $request->descripcion;
        $oferta->experiencia = $request->experiencia;
       
        $oferta->salario_1 = $request->salario_1;
        if($request->has("salario_2"))
        {
            $oferta->salario_2 = $request->salario_2;
        }
        
        $oferta->moneda_id = $request->moneda;
        $oferta->estado_id = $request->estado;
        $oferta->ciudad = $request->ciudad;
        $oferta->ubicacion = $request->ubicacion;
        $oferta->contacto = $request->contacto;
        
        $oferta->empresa_id = Auth::guard()->user()->id;
        $oferta->save();
        $resultado=[
            "success" => true,
            "message" => "Agregado exitosamente."
        ];
        return response()->json($resultado);
    }
    /**
     * Actualiza la informacion de una oferta de trabajo
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        $this->validateOffer($request);
        $oferta = Auth::user()->ofertas()->where(["id" => $id])->get()->first();
        $oferta->titulo = $request->titulo;
        $oferta->tipo = $request->tipo;
        $oferta->categoria_id = $request->categoria;
        $oferta->descripcion = $request->descripcion;
        $oferta->experiencia = $request->experiencia;
       
        $oferta->salario_1 = $request->salario_1;
        if($request->has("salario_2")) 
        {
            $oferta->salario_2 = $request->salario_2;
        }
        
        $oferta->moneda_id = $request->moneda;
        $oferta->estado_id = $request->estado;
        $oferta->ciudad = $request->ciudad;
        $oferta->ubicacion = $request->ubicacion;
        $oferta->contacto = $request->contacto;
        
        $oferta->update();
        $resultado=[
            "success" => true,
            "message" => "Actualizado exitosamente."
        ];
        return response()->json($resultado);
    }
    /**
     * Elimina una oferta de trabajo
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {
        $oferta = Auth::user()->ofertas()->where(["id" => $id])->get()->first();
        $oferta->delete();
        $resultado=[
            "success" => true,
            "message" => "Borrado exitosamente."
        ];
        return response()->json($resultado);
    }
    /**
     * Obtiene todas los ofertas de trabajo por empresa
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOffersByUser(Request $request)
    {
        $page_number = $this->getDefaultPageNumber();
        $resultados =  Oferta::where([
            ["empresa_id" ,"=",Auth::user()->id],
            ["titulo","like","%$request->keyword%"]]
            )
            ->paginate($page_number);
        return response()->json($resultados);
    }
    /**
     * Obtiene todas los ofertas de trabajo por empresa
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOfferByUser(Request $request,$id)
    {
        $page_number = $this->getDefaultPageNumber();
        $resultados =  Oferta::where(["empresa_id" => Auth::user()->id, "id" => $id ])->first();
        if($resultados === null)
        {
            return response("",403);
        }
        return response()->json($resultados);
    }
    
     /**
     * Valida los datos del formulario de oferta de trabajo
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateOffer(Request $request)
    {
        $rules = $this->getRules();
        if($request->has("id"))
        {
            $rules["id"] = "required|exists:ofertas,id";
        }
        $request->validate($rules);
    }
    /**
     * Obtiene las reglas base para validar los datos del formulario de oferta de trabajo
     * 
     * @return array
     */
    private function getRules()
    {
      $rules =  [
            "titulo" => "required|string",
            "tipo" => "required|string|in:full-time,part-time",
            "categoria" => "required|integer|exists:categorias,id",
            "descripcion" => "required|string",
            "experiencia" => "required|integer|in:1,2,5,10",
            "salario_1" => "required|numeric",
            "salario_2" => "bail|nullable|numeric",
            "estado" => "required|string",
            "ciudad" => "required|string",
            "ubicacion" => "required|string",
            "contacto" => "required|string",
            "habilitado" => "nullable|boolean",
        ];
        return $rules;
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
