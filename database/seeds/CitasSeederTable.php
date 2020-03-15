<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitasSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('citas')->insert([
            [
                'titulo' => 'Cita 001',
                'fecha_inicio' => '2020-05-11 10:47:11',
                'fecha_fin' => '2020-05-11 12:31:10',
                'descripcion' => 'Descripcion de la Cita 001',
                'usuario_id' => 1
            ],
            [
                'titulo' => 'Cita 002',
                'fecha_inicio' => '2020-05-13 10:47:11',
                'fecha_fin' => '2020-05-13 10:58:10',
                'descripcion' => 'Cita 002 apuntes',
                'usuario_id' => 2
            ],
            [
                'titulo' => 'Cita 003',
                'fecha_inicio' => '2020-05-21 10:47:11',
                'fecha_fin' => '2020-05-22 12:31:10',
                'descripcion' => 'Descripcion de la Cita 003',
                'usuario_id' => 3
            ],
            [
                'titulo' => 'Cita 004',
                'fecha_inicio' => '2020-05-23 10:47:11',
                'fecha_fin' => '2020-05-23 12:31:10',
                'descripcion' => 'Descripcion de la Cita 004',
                'usuario_id' => 1
            ],
        ]);
    }
}
