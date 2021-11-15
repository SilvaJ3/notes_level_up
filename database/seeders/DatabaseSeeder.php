<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            TagSeeder::class,
            LikeSeeder::class,
            RoleNoteSeeder::class,
            NoteSeeder::class,
            NoteTagPivotSeeder::class,
            NoteRoleUserPivotSeeder::class,
        ]);
    }
}
