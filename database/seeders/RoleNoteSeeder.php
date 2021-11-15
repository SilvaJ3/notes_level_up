<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("role_notes")->insert([
            [
                "role_notes" => "auteur",
            ],
            [
                "role_notes" => "editeur",
            ],
        ]);
    }
}
