<?php

use Illuminate\Database\Seeder;
use App\Cases;
use App\Projects;

class CasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Cases::class, 5)->create();
    }
}
