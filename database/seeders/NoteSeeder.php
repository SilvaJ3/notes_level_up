<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("notes")->insert([
            [
                "title" => "How to center a div",
                "content" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non maiores iure corrupti officia delectus exercitationem assumenda adipisci, dignissimos dolorum saepe. Nam odio voluptas dicta at reprehenderit, incidunt labore nulla voluptate magnam dolore eius, temporibus nemo laborum earum possimus ab a distinctio neque. Unde saepe quis in quas voluptas possimus omnis?",
                "like" => 0,
            ],
        ]);
    }
}
