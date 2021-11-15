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
        DB::table("users")->insert([
            [
                "name" => "Admin",
                "email" => "admin@admin.com",
                "password" => bcrypt("admin@admin.com"),
                "role_id" => 1,
                "likes" => 10,
            ],
            [
                "name" => "user1",
                "email" => "user1@user1.com",
                "password" => bcrypt("user1@user1.com"),
                "role_id" => 2,
                "likes" => 10,
            ],
            [
                "name" => "user2",
                "email" => "user2@user2.com",
                "password" => bcrypt("user2@user2.com"),
                "role_id" => 2,
                "likes" => 10,
            ],
        ]);
    }
}