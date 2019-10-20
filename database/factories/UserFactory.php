<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('admin'), // password
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'nombre_empresa' => $faker->name,
        'estado_id' => 5,
        'ciudad' => $faker->city,
        'ubicacion'=> $faker->address,
        'identificacion' => $faker->regexify('[A-Za-z0-9]{9}'),
        "telefono" => $faker->phoneNumber,
        'sitio_web' => $faker->url,
        'logo_id' => rand(1,20)
        
    ];
});
