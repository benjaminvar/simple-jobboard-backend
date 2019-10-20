<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string("nombre");
            $table->string("apellido");
            $table->string("nombre_empresa")->nullable();
            $table->integer("estado_id")->nullable();
            $table->string("ciudad")->nullable();
            $table->string("ubicacion")->nullable();
            $table->string("identificacion")->nullable();
            $table->string("telefono");
            $table->string("sitio_web")->nullable();
            $table->integer("logo_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
