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

$class = App::make(ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface::class);

if ($class->model instanceof Illuminate\Database\Eloquent\Model)
    $factory->define(get_class($class->model), function (Faker\Generator $faker) {
        return [
            //'user_id' => 'factory|App\Models\User',
            'mandante' => $faker->word,
            'nome' => $faker->name(),
            'data_nascimento' => $faker->date(),
            'observacao' => $faker->text(),
        ];
    });
elseif ($class instanceof Doctrine\ORM\EntityRepository) {
    \League\FactoryMuffin\Facade::define(($class->model), array(
        'mandante' => 'word',
        'nome'   => 'sentence',
        'observacao'   => 'sentence',
        'created_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
        'updated_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
        'data_nascimento' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
    ));
}