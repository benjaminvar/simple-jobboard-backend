<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    
    public function oferta()
    {
       return $this->belongsTo(Oferta::class,"oferta_id","id"); 
    }
    public function hoja()
    {
       return $this->belongsTo(Archivo::class,"hoja_vida","id"); 
    }
}
