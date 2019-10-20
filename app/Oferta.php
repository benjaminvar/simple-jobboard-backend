<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Oferta extends Model
{
    use SoftDeletes;
    public function empresa()
    {
        return $this->belongsTo(User::class,"empresa_id","id");
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class,"categoria_id","id");
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class,"moneda_id","id");
    }
}
