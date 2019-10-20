<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("titulo");
            $table->string("tipo")->enum("full-time","part-time");
            $table->integer("categoria_id");
            $table->text("descripcion");
            $table->integer("experiencia");
           
            $table->float("salario_1");
            $table->float("salario_2")->nullable();
            $table->integer("moneda_id");
            $table->integer("estado_id");
            $table->string("ciudad");
            $table->string("ubicacion");
            $table->text("contacto");
            $table->boolean("habilitado")->default(true);
            $table->integer("empresa_id");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ofertas');
    }
}
