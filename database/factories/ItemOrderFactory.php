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
$class = App::make(ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface::class);

if ($class->model instanceof Illuminate\Database\Eloquent\Model)
    $factory->define(get_class($class->model), function (Faker\Generator $faker) {
        return [
            'mandante' => $faker->word,
            'quantidade' => $faker->randomNumber(2),
            'valor_unitario' => $faker->randomFloat(2),
    //        'order_id' => factory(App\Models\Order::class)->create()->id,
    //        'cost_id' => factory(App\Models\CostAllocate::class)->create()->id,
            'descricao' => $faker->text(),
        ];
    });
elseif ($class instanceof Doctrine\ORM\EntityRepository) {
    \League\FactoryMuffin\Facade::define(($class->model), array(
        'mandante' => 'word',
        'quantidade'   => 'number',
        'valor_unitario'   => 'number',
        'descricao'   => 'sentence',
        'created_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
        'updated_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
    ));
}