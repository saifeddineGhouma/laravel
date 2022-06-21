<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        "product_name"=>$faker->text(20),
        "price"=>$faker->numberBetween(5,60),
        "quantity"=>$faker->numberBetween(1,5),
    ];
});
