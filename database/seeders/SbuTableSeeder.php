<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SbuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sbus')->insert([
            'name' => 'JMI Syringes & Medical Device Ltd',
            'slug' => 'syringes',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);
        DB::table('sbus')->insert([
            'name' => 'JMI Hospital Requisite Mfg Ltd',
            'slug' => 'hospital',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);
        DB::table('sbus')->insert([
            'name' => 'JMI Vaccine Ltd',
            'slug' => 'vaccine',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);
        DB::table('sbus')->insert([
            'name' => 'JMI Engineering Ltd',
            'slug' => 'engineering',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);
        DB::table('sbus')->insert([
            'name' => 'JMI Printing and Packaging',
            'slug' => 'printing',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);
        DB::table('sbus')->insert([
            'name' => 'JMI Builders & Construction',
            'slug' => 'builders',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);
        DB::table('sbus')->insert([
            'name' => 'JMI Export Import Co.Ltd',
            'slug' => 'export',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);
    }
}
