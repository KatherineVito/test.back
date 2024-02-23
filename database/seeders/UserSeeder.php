<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Joseph David', 'email' => 'joseph2019d@gmail.com', 'password' => '$2y$10$GJaqfOy999NQbcHuUfJGAuKCxRwSiOK.bXJSVczZxB98AzvdeQkQu', 'rol' => 'superadmin'],
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
