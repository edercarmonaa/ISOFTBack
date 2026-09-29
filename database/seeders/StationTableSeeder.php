<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('stations')->insert([
          'station_id' => 4,
          'station_name' => 'ESTACION EJEMPLO',
          'station_razon' => 'Empresa Ejemplo SA de CV',
          'station_rfc' => 'XAXX010101000',
          'station_dire' => 'Calle Ficticia 123',
          'station_mpo' =>'Municipio Ejemplo',
          'station_edo' => 'Estado Ejemplo',
          'station_cp' => '00000',
          'station_phone' => '5550000000',
          'station_gas' => '12',
          'station_diesel' => '2',
      ]);
    }
}
