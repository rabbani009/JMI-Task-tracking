<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Faisal rabbani',
            'email' => 'farzad.edsoft@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' => 'system',
            'class' => '', 
            'section' => '',
            'belongs_to' => 0,
            'role_id' => 1,
            'permissions' => 'create, read, update, delete',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' => 'admin',
            'class' => '',
            'section' => '',
            'belongs_to' => 0,
            'role_id' => 1,
            'permissions' => 'create, read, update, delete',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'user one',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' => 'user',
            'belongs_to' => 0,
            'role_id' => 2,
            'permissions' => 'create, read, update',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'user two',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' => 'user',
            'belongs_to' => 0,
            'role_id' => 2,
            'permissions' => 'create, read, update',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'user three',
            'email' => 'user3@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' => 'user',
            'belongs_to' => 0,
            'role_id' => 2,
            'permissions' => 'create, read, update',
            'status' => 1,
            'created_at' => Carbon::now(),
            'created_by' => 1
        ]);


       

    }
}
