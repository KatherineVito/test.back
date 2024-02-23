<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Joseph David', 'email' => 'josetex_12@gmail.com', 'password' => '$2y$10$GJaqfOy999NQbcHuUfJGAuKCxRwSiOK.bXJSVczZxB98AzvdeQkQu', 'rol' => 'superadmin'],
            ['name' => 'Eduardo Telaya Escobedo', 'email' => 'luis.eduardo.telaya@gmail.com', 'password' => '$2y$10$b.3XqDMqAPuMV7AtcbyZpePaJYAeHgRjvpfcHtWbXcMsjyr6T2ZJK', 'rol' => 'superadmin'],
            ['name' => 'Rosa Alegre Veliz', 'email' => 'hi@heydru.com', 'password' => '$2y$10$b.3XqDMqAPuMV7AtcbyZpePaJYAeHgRjvpfcHtWbXcMsjyr6T2ZJK', 'rol' => 'superadmin'],
            ['name' => 'Alejandra Amezaga', 'email' => 'alejandra.amezaga.aao@gmail.com', 'password' => '$2y$10$b.3XqDMqAPuMV7AtcbyZpePaJYAeHgRjvpfcHtWbXcMsjyr6T2ZJK', 'rol' => 'superadmin'],
        ];
        foreach ($data as $value) {
            DB::table('users')->insert(
                [
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'password' => $value['password'],
                    'rol' => $value['rol']
                ]
            );
        }
    }
}
