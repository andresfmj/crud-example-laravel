<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsuariosSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'nombre' => 'Andres Fernando', 
                'email' => 'webmaster@ferdinania.com', 
                'password' => bcrypt('as123456'),
                'api_token' => Str::random('60'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
