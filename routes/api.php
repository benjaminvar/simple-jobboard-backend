<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Rutas creades para el sistema de autenticacion
 */
Route::prefix("auth")->middleware(["cors"])->group(function(){
    Route::post('login', 'Auth\LoginController@login');

    Route::post('token/verify','Auth\LoginController@verifyToken');

    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('refresh', 'Auth\LoginController@refresh');
    
    Route::post('register', 'Auth\RegisterController@register');
    
    Route::post('reset/email',"Auth\ForgotPasswordController@sendResetLinkEmail");
    Route::post('reset/password',"Auth\ResetPasswordController@reset")->name("password.reset");
    Route::get('verify/resend',"Auth\VerificationController@resend");
    Route::get('verify/email',"Auth\VerificationController@verify");

    Route::post('password/token',"Auth\ResetPasswordController@validatePasswordToken");

    Route::get("/email/available","Auth\RegisterController@emailAvailable");
    Route::post("/social/{provider}/register","SocialController@register");
    Route::post("/social/{provider}/login","SocialController@login");

});

/**
 * Rutas para administrar la compania y componentes relacionados(Aplicaciones y Ofertas de Trabajo)
 */
Route::prefix("company")->middleware(["auth:api", "cors"])->group(function(){
    Route::get('me', 'EmpresaController@me');
    
    Route::get('overview', 'EmpresaController@getOverview');
    Route::post('update', 'EmpresaController@updateCompany');
    Route::post('user/update', 'EmpresaController@updateUser');
    Route::post('password/update', 'EmpresaController@updatePassword');
    Route::post('offer/add', 'OfertaController@create');
    Route::get('offers/view', 'OfertaController@getOffersByUser');
    Route::get('offer/{id}/view', 'OfertaController@getOfferByUser');
    Route::post('offer/{id}/update', 'OfertaController@update');
    Route::post('offer/{id}/delete', 'OfertaController@delete');
    Route::get('applications/view', 'AplicacionController@getAll');
    Route::get('application/{aplicacion}/view', 'AplicacionController@get');
    Route::get("/cv/{aplicacion}/view","ArchivoController@getCV");
    Route::get("/cv/{aplicacion}/download","ArchivoController@downloadCV");
});
/**
 * Rutas para el acceso publico
 */
Route::middleware(["cors"])->group(function(){
   
   
	 Route::get("/jobs","OfertaController@getAll");
	 Route::get("/jobs/search","OfertaController@search");
     Route::get("/job/{id}","OfertaController@get");
     
     Route::post("/job/{oferta}/apply","AplicacionController@create");
     
     Route::get("/states","EstadoController@getAll");
     Route::get("/categories","CategoriaController@getAll");
     
     Route::get("/currencies","MonedaController@getAll");

     Route::get("/image/{user}","ArchivoController@getUserImage");

     Route::post("/contact","ContactoController@index")->middleware(["captcha"]);
 });


