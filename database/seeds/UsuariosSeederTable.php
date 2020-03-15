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
                'nombre' => 'User 001', 
                'email' => 'user001@hdprueba.com', 
                'password' => bcrypt('as123456'),
                'api_token' => Str::random('60'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nombre' => 'User 002', 
                'email' => 'user002@hdprueba.com', 
                'password' => bcrypt('as123456'),
                'api_token' => Str::random('60'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nombre' => 'User 003', 
                'email' => 'user003@hdprueba.com', 
                'password' => bcrypt('as123456'),
                'api_token' => Str::random('60'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
