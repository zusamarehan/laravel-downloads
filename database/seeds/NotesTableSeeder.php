<?php

use Illuminate\Database\Seeder;
use App\Notes;
use App\Projects;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Notes::class, 10)->create();
    }
}
