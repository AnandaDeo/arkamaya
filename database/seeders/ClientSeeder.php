<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            Client::create([
                'client_name' => 'NEC',
                'client_address' => 'Jakarta'
            ]);
            Client::create([
                'client_name' => 'TAM',
                'client_address' => 'Jakarta'
            ]);
            Client::create([
                'client_name' => 'TUA',
                'client_address' => 'Bandung'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            echo $e->getMessage();
            //throw $th;
        }
    }
}