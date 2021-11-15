<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteRoleUserPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("note_role_user_pivots")->insert([
            [
                "note_id" => 1,
                "role_notes_id" => 1, // Auteur
                "user_id" => 2, // User1
            ]
        ]);
    }
}
