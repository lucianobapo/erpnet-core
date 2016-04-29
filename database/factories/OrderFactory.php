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

$class = App::make(ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface::class);
//dd($class);
//dd(($class instanceof Doctrine\ORM\EntityRepository));
//dd($class->model instanceof Illuminate\Database\Eloquent\Model);
//dd($class->model instanceof Doctrine\ORM\EntityManager);
//dd($class instanceof App\Models\Eloquent\Repositories\OrderRepositoryEloquent);
//dd($class instanceof App\Models\Doctrine\Repositories\OrderRepositoryDoctrine);
//dd($class instanceof App\Models\RepositoryLayer\OrderRepositoryInterface);

if ($class->model instanceof Illuminate\Database\Eloquent\Model)
    $factory->define(get_class($class->model), function (Faker\Generator $faker) {
        return [
            'mandante' => $faker->word,
            'posted_at'      => $faker->date(),
    //        'partner_id' => factory(App\Models\Partner::class)->create()->id,
            'descricao' => $faker->text(),
        ];
    });
elseif ($class instanceof Doctrine\ORM\EntityRepository) {
    \League\FactoryMuffin\Facade::define(($class->model), array(
        'mandante' => 'word',
//        'posted_at'    => 'date|Y-m-d',
        'descricao'   => 'sentence',
        'created_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
        'updated_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
        'posted_at' => function ($object, $saved) {
            return \Carbon\Carbon::now();
        },
    ));
}



