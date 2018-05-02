<?php

use App\Reply;
use App\Thread;
use App\Channel;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function() {
            return factory('App\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});

$factory->define(Channel::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => $name
    ];
});

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'thread_id' => function() {
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
