<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function ofertas()
    {
        return $this->hasMany(Oferta::class,"categoria_id","id");
    }

}
