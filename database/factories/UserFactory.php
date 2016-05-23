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

$class = App::make(ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface::class);

if ($class->model instanceof Illuminate\Database\Eloquent\Model)
    $factory->define(get_class($class->model), function (Faker\Generator $faker) {
        return [
            //'user_id' => 'factory|App\Models\User',
            'mandante' => $faker->word,
            'name' => $faker->name,
            'email' => $faker->email,
            'provider' => $faker->word,
            'provider_id' => $faker->randomNumber(),
        ];
    });
elseif ($class instanceof Doctrine\ORM\EntityRepository) {
    \League\FactoryMuffin\Facade::define(($class->model), array(
        'mandante' => 'word',
        'name'   => 'sentence',
        'email'   => 'email',
        'provider'   => 'word',
        'provider_id' => 'randomNumber',
    ));
}