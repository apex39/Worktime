<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Record;
use App\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'id' => $faker->numberBetween(1000,2000),
        'name' => $faker->name,
        'surname' => $faker->name,
        'username' => $faker->userName,
        'working_hours' => 8,
        'active' => true,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Record::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->numberBetween(1000,2000),
        'action_id' => random_int(1,2),
        'user_id' => 6,
        'finished' => true,
    ];
});

$factory->state(User::class, 'worker', function (Faker\Generator $faker) {
    return [
        'role_id' => function () {
            return App\Role::where('role_name', 'worker')->first();
        }
    ];
});

$factory->state(Record::class, 'forStartedTime', function (Faker\Generator $faker) {
    return [
        'user_id' => 13,
    ];
});

