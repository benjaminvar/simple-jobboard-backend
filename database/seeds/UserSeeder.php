<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class,20)->create()->each(function(\App\User $user)
        {
            factory(\App\Oferta::class,2)->create(["empresa_id" => $user->id]);
        });
    }
}
