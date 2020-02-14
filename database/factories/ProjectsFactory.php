<?php

/** @var Factory $factory */

use App\Projects;
use App\Organizations;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Projects::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'desc' => $faker->sentence,
        'start_date' => $faker->date(),
        'end_date' => $faker->date(),
    ];
});
