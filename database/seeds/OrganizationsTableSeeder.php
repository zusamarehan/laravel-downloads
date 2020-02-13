<?php

use Illuminate\Database\Seeder;
use App\Organizations;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Organizations::class, 50)->create();
    }
}
