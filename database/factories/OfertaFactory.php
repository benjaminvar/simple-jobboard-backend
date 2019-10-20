<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Oferta;
use Faker\Generator as Faker;

$factory->define(Oferta::class, function (Faker $faker) {
    $segundo_salario = rand(1,10) > 5;
    return [
        
            "titulo" => $faker->jobTitle,
            "tipo" => $faker->randomElement(["full-time","part-time"]),
            "categoria_id" => rand(1,42),
            "descripcion" => $faker->text,
            "experiencia" => $faker->randomElement([0,1,2,5,10]),
            "salario_1" => $faker->randomFloat(2,20000,200000),
            "salario_2" => $segundo_salario ? $faker->randomFloat(2,20000,200000) : null,
            "moneda_id" => rand(1,3),
            "estado_id" => 5,
            "ciudad" => $faker->city,
            "ubicacion" => $faker->address,
            "contacto" => $faker->text,
    ];
});
