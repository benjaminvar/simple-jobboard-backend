<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailContacto;
use \Validator;
use \Mail;
class ContactoController extends Controller
{
    /**
     * Procesa el formulario de contacto
     * 
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $validator = $this->getValidator($request);
        if($validator->fails())
        {
            return response()->json($validator->errors(),400);
        }
        $datos = [
            "nombre_completo" => $request->nombre_completo,
            "email" => $request->email,
            "telefono" => $request->telefono,
            "mensaje" => $request->mensaje
        ];
        $this->SendMail($datos);
        return response("",200);
    }
    /**
     * Envia mensaje al correo del propietario
     * 
     * @param array $datos
     */
    protected function SendMail($datos)
    {
        Mail::to(config("app.site_owner_email"))->send(new MailContacto($datos));
    }
    /**
     * Devuelve el validador para el formulario de contacto
     * 
     * @param \Illuminate\Http\Request $request
     */
    protected function getValidator(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "nombre_completo" => "required|string",
            "email" => "required|email",
            "telefono" =>  "required|string",
            "mensaje" => "required|string"
        ]);
        return $validator;
    }
}
