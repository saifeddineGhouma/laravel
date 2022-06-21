<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        "name"=>$faker->text(20),
        "description"=>$faker->text,
        "image"=>$faker->imageUrl(),
        "price"=>$faker->numberBetween(5,60)
    ];
});
