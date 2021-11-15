<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteTagPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("note_tag_pivots")->insert([
            [
                "note_id" => 1,
                "tag_id" => 2,
            ]
        ]);
    }
}
