<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;
class SocialController extends Controller
{
    /**
     * Registra usuario de facebook o google
     * 
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    function register($provider)
    {
        

        $fields = [];
        if($provider === "facebook")
        {
			$user = Socialite::driver($provider)->fields(["first_name","last_name","email"])->stateless()->user();
            $fields = [
                "nombre" =>$user->user['first_name'],
                "apellido" => $user->user['last_name'],
                "email" => $user->getEmail(),
				"password" => "",
                "telefono" => "",
                "provider" => $provider,
                "provider_id" => $user->id
            ];
        }else if($provider === "google")
        {
			$user = Socialite::driver($provider)->stateless()->user();
            $fields = [
                "nombre" => $user->user['name']['givenName'],
                "apellido" => $user->user['name']['familyName'],
                "email" => $user->getEmail(),
				"password" => "",
                "telefono" => "",
                "provider" => $provider,
                "provider_id" => $user->id
            ];
        }
        $userAlreadyExist = User::where(["email" => $user->getEmail()])->exists();
        if($userAlreadyExist)
        {
            return response()->json("User already exists",400);
        }
        User::create($fields);
        return response("",200);
    }
    /**
     * Inicia sesion con usuario de facebook o google
     * 
     * @param string $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
       $userToLog = User::where([
           "email" => $user->getEmail(),
           "provider" => $provider,
           "provider_id" => $user->id
       ])->get()->first();
       if($userToLog === null)
       {
           return response()->json("Unauthorized",401);
       }
	   $token = Auth::login($userToLog);
       return $this->respondWithToken($token);
    }
	/**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
