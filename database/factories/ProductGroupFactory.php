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

$class = App::make(ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface::class);

if ($class->model instanceof Illuminate\Database\Eloquent\Model)
    $factory->define(get_class($class->model), function (Faker\Generator $faker) {
        return [
            'mandante' => $faker->word,
            'grupo' => $faker->name(),
        ];
    });
elseif ($class instanceof Doctrine\ORM\EntityRepository) {
    \League\FactoryMuffin\Facade::define(($class->model), array(
        'mandante' => 'word',
        'grupo'   => 'sentence',
        'created_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
        'updated_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
    ));
}