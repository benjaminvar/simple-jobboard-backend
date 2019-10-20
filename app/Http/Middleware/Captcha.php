<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class Captcha
{
    /**
     * Get json response from the google captcha api
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function getResponse(Request $request)
    {
        $client = new Client();
        $response = $client->post("https://www.google.com/recaptcha/api/siteverify",
        [
            'form_params' => [
                "response" => $request->captchaToken,
                "secret" => config("captcha.captcha.secret")
            ]
           
        ]
        );
        $json = json_decode((string)$response->getBody(),true);
        return $json;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $this->getResponse($request);
        if(!$response["success"])
        {
            return response()->json($response,400);
        }
        return $next($request);
    }
}
