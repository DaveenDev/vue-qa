<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'body'=>$faker->paragraph(rand(1,3),true), //2nd argument true - means to conver paragraphs into single string
        'user_id'=>App\User::pluck('id')->random(), //to generate random user id based on usersID in DB
        //'votes_count'=>rand(0,5),
    ];
});
