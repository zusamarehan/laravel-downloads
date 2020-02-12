<?php

/** @var Factory $factory */

use App\Cases;
use App\Projects;
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

$factory->define(Cases::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'desc' => $faker->sentence,
        'status' => $faker->randomElement(['open' ,'close']),
        'projects_id' => rand(1, Projects::count()),
    ];
});
