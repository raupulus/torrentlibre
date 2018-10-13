<?php

/**
 * @tests/unit/templates/fixtures/users.php
 *
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'username' => $faker->unique()->userName,
    'password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
    'phone'    => $faker->phoneNumber,
    'city'     => $faker->city,
];
