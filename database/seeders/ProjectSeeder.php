<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            Project::create([
                'project_name' => 'WMS',
                'client_id' => 1,
                'project_start_date' => '2022-07-28',
                'project_end_date' => '2022-08-28',
                'project_status' => 'OPEN',
            ]);
            Project::create([
                'project_name' => 'FILMS',
                'client_id' => 2,
                'project_start_date' => '2022-06-01',
                'project_end_date' => '2022-08-31',
                'project_status' => 'DOING',
            ]);
            Project::create([
                'project_name' => 'DOC',
                'client_id' => 2,
                'project_start_date' => '2022-01-01',
                'project_end_date' => '2022-04-30',
                'project_status' => 'DONE',
            ]);
            Project::create([
                'project_name' => 'POS',
                'client_id' => 3,
                'project_start_date' => '2022-05-01',
                'project_end_date' => '2022-08-31',
                'project_status' => 'DOING',
            ]);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            echo $e->getMessage();
        }
    }
}