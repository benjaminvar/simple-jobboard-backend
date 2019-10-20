<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\ResetPasswordNotification;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $fillable = [
        'nombre',
        'apellido', 
        'telefono', 
        'email', 
        'password',
        'nombre_empresa',
        'identificacion',
        'estado_id',
        'ciudad',
        'ubicacion',
        'sitio_web',
        'logo_id',
		'provider',
		'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function ofertas()
    {
        return $this->hasMany(Oferta::class,"empresa_id");
    }
    public function logo()
    {
        return $this->belongsTo(Archivo::class,"logo_id");
    }
    public function aplicaciones()
    {
        return $this->hasManyThrough(Aplicacion::class,Oferta::class,"empresa_id");
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class,"estado_id");
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token,$this));
    }
}
