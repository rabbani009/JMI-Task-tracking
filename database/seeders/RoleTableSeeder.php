<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           //1.
           DB::table('roles')->insert([
            'name' => 'System Admin',
            'slug' => 'system_admin',
            'description' => 'System wide administration',
            'has_accesses' => 'get.login, post.login, get.dashboard',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);

        //2.
        DB::table('roles')->insert([
            'name' => 'Sbu Admin',
            'slug' => 'sbu_admin',
            'description' => 'application wide administration to all routes',
            'has_accesses' => 'get.login, post.login, get.dashboard',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);

        //3.
        DB::table('roles')->insert([
            'name' => 'Sbu user',
            'slug' => 'sbu_user',
            'description' => 'application wide permission to specific routes',
            'has_accesses' => 'get.login, post.login, get.dashboard',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);

    }
}
