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
$class = App::make(ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface::class);

if ($class->model instanceof Illuminate\Database\Eloquent\Model)
    $factory->define(get_class($class->model), function (Faker\Generator $faker) {
        return [
            'mandante' => $faker->word,
            'cep' => $faker->postcode,
            'logradouro' => $faker->streetName,
            'numero' => $faker->buildingNumber,
            'bairro' => $faker->streetSuffix,
        ];
    });
elseif ($class instanceof Doctrine\ORM\EntityRepository) {
    \League\FactoryMuffin\Facade::define(($class->model), array(
        'mandante' => 'word',
        'cep' => 'postcode',
        'logradouro' => 'streetName',
        'numero' => 'buildingNumber',
        'bairro' => 'streetSuffix',
    ));
}