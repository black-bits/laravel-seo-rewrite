<?php

use Faker\Generator as Faker;

$factory->define(\BlackBits\LaravelSeoRewrite\Models\SeoRewrite::class, function (Faker $faker) {

    return [
        'source' => function () use ($faker) {

            $slug = '';

            for ($i = 0; $i < $faker->numberBetween(1, 3); $i++) {
                $slug .= '/' . $faker->unique()->slug(4, true);
            }

            return $slug;
        },
        'destination' => $faker->url,

        'type' => $faker->randomElement([301, 307, 308]),
    ];
});
