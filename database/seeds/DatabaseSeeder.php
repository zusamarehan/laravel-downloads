<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public $tables = ['users','projects', 'cases', 'notes', 'tasks'];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($this->tables as $table){
            DB::table($table)->truncate();
        }

         $this->call(UsersTableSeeder::class);
         $this->call(ProjectsTableSeeder::class);
         $this->call(CasesTableSeeder::class);
         $this->call(TasksTableSeeder::class);
         $this->call(NotesTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
