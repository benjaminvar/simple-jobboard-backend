<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("nombre");
            $table->string("apellido");
            $table->string("telefono");
            $table->string("direccion");
            $table->string("profesion");
            $table->string("descripcion");
            $table->integer("hoja_vida");
            $table->string("oferta_id");
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aplicacions');
    }
}
