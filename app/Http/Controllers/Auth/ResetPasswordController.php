<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
   
    protected function resetPassword($user, $password)
    {
        $user->password = \Hash::make($password);

       

        $user->save();

        event(new PasswordReset($user));

      
    }
    /**
     * Devuelve la respuesta para el restablecimiento de clave exitoso
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\JsonResponse
     */

    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json(["message" => "success"],200);
    }

    /**
     * Devuelve la respuesta para el restablecimiento de clave fallido
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {

        return response()->json(["message" => "error"],400);
    }
     /**
     * Validate Token for password reset
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function validatePasswordToken(Request $request)
    {
        $user = User::where(["email" => $request->email])->get()->first();
        $token = $request->token;
        if($user !== null)  
        {
            if($this->broker()->tokenExists($user,$token))
            {
                return response("",200);
            }
        }
        return response("",400);
    }
}
