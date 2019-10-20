<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Archivo;
use App\Oferta;
use App\Aplicacion;
use App\Estado;
use Auth;
use \Validator;
use \File;
use \Hash;
class EmpresaController extends Controller
{
    public function __construct(){
    
    }
    /**
     * Obtiene el usuario autenticado
     * 
     * @return \App\User
     */
   public function me()
   {
        return Auth::user();
   }

   public function getOverview()
   {
        Auth::user()->aplicaciones->count();
        $cantidad_aplicaciones = Auth::user()->aplicaciones->count();
        $cantidad_ofertas = Auth::user()->ofertas->count();
        $resultado = [
             "aplicaciones" => $cantidad_aplicaciones,
             "ofertas" => $cantidad_ofertas
        ];
        return response()->json($resultado);
   }
   /**
    * Actualiza la clave de usuario
    *
    * @param \Illuminita\Http\Request $request
    * @return \Illuminate\Http\JsonResponse
    */
   public function updatePassword(Request $request)
   {
     $user = Auth::user();
     $validator = $this->getPasswordUpdateValidator($request);
     if($validator->fails())
     {
          return  response("",400);

     }
     $user->update([
          "password" => Hash::make($request->password)
     ]);
     return response("",200);
   }
   /**
    * Actualiza la informacion de usuario
    *
    * @param \Illuminita\Http\Request $request
    * @return \Illuminate\Http\JsonResponse
    */
   public function updateUser(Request $request)
   {
     $user = Auth::user();
     $validator = $this->getUserUpdateValidator($request);
     if($validator->fails())
     {
          return response()->json($validator->errors()->all(),400);
     }
     $user->update([
          "nombre" => $request->nombre,
          "apellido" => $request->apellido,
          "email" => $request->email,
          "telefono" => $request->telefono,
     ]);
     return response("",200);
   }
   /**
    * Actualiza la informacion de la compañia
    *
    * @param \Illuminita\Http\Request $request
    * @return \Illuminate\Http\JsonResponse
    */
   public function updateCompany(Request $request)
   {
     $user = Auth::user();
     $validator = $this->getCompanyUpdateValidator($request);
     if($validator->fails())
     {
          return response()->json($validator->errors()->all(),400);
     }
     if($request->hasFile("logo"))
     {
         $archivo = new Archivo();
         $logo = $request->file("logo");
         $nombre = $logo->getClientOriginalName();
         $tipo = $logo->getMimeType();
         $path = \Storage::putFile('files', $logo);
         $archivo->nombre = File::basename($path);
         $archivo->nombre_original = $nombre;
         $archivo->tipo = $tipo;
         $archivo->url = $path;
         $archivo->save();
    
     }

     $user->update([
          "nombre_empresa" => $request->nombre_empresa,
          "identificacion" => $request->identificacion,
          "estado_id" => $request->estado,
          "ciudad" => $request->ciudad,
          "ubicacion" => $request->ubicacion,
          "sitio_web" => $request->sitio_web,
          "logo_id" => $archivo->id
     ]);
     return response("",200);
   }
   /**
    * Obtiene el validador del formulario para actualizar la contraseña 
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Validator
    */
   protected function getPasswordUpdateValidator(Request $request)
   {
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
             "oldPassword" => "required|min:8",
             "password" => "required|min:8|confirmed"
        ])
        ->after(function($validator)use($request,$user){
               if(!Hash::check($request->oldPassword,$user->password))
               {
                    $validator->errors()->add("oldPassword","La contraseña no es valida.");
               }
        });
        return $validator;
   }
    /**
    * Obtiene el validador del formulario para actualizar los datos de usuario 
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Validator
    */
   protected function getUserUpdateValidator(Request $request)
   {
        $user = Auth::user();
        $rules = [
             "nombre" => "required|string",
             "apellido" => "required|string",
             "telefono" => "required|string",
             "email" => "required|email"
        ];
        if($user->email !== $request->email)
        {
          $rules["email"] = "required|email|unique:users,email";
        }
        $validator = Validator::make($request->all(),$rules);
        return $validator;
   }
    /**
    * Obtiene el validador del formulario para actualizar los datos de la compania
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Validator
    */
   protected function getCompanyUpdateValidator(Request $request)
   {
        $validator = Validator::make($request->all(),[
             "nombre_empresa" => "required|string",
             "identificacion" => "required|string",
             "estado" => "required",
             "ciudad" => "required|string",
             "ubicacion" => "bail|nullable|string",
             "sitio_web" => "bail|nullable|string",
             "logo" => "bail|nullable|image|max:5120"
        ]);
        return $validator;
   }
}
