<?php

namespace ErpNET\App\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\Extensions\GedmoExtensionsServiceProvider;
use LaravelDoctrine\ORM\DoctrineServiceProvider;

class ErpnetServiceProvider extends ServiceProvider
{
//    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
//    {
//        parent::__construct($app);
//    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

//        if (!$this->app->routesAreCached()) {
//            require __DIR__ . "/../Http/Routes.php";
//        }

//        $this->loadViewsFrom( __DIR__."/../../resources/views", "erpnet");

        $this->publishes([
            __DIR__."/../../database/migrations" => database_path("migrations")
        ], 'migrations');

        $this->app->register(DoctrineServiceProvider::class);
        $this->app->register(GedmoExtensionsServiceProvider::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \ErpNET\App\Interfaces\ProductServiceInterface::class,
            \ErpNET\App\Services\ProductService::class
        );
        $this->app->bind(
            \ErpNET\App\Interfaces\SummaryServiceInterface::class,
            \ErpNET\App\Services\SummaryService::class
        );
        $this->app->bind(
            \ErpNET\App\Interfaces\OrderServiceInterface::class,
            \ErpNET\App\Services\OrderService::class
        );
        $this->app->bind(
            \ErpNET\App\Interfaces\PartnerServiceInterface::class,
            \ErpNET\App\Services\PartnerService::class
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\SummaryRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\SummaryRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\SummaryRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\Summary::class
            ])
        );
        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\SummaryProductContentRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\SummaryProductContentRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\SummaryProductContentRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\SummaryProductContent::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\UserRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\UserRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\UserRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\User::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\SharedCurrencyRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\SharedCurrencyRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\SharedCurrencyRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\SharedCurrency::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\SharedOrderTypeRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\SharedOrderTypeRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\SharedOrderTypeRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\SharedOrderType::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\SharedOrderPaymentRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\SharedOrderPaymentRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\SharedOrderPaymentRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\SharedOrderPayment::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\AddressRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\AddressRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\AddressRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\Address::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\ContactRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\ContactRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\ContactRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\Contact::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\ItemOrderRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\ItemOrderRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\ItemOrderRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\ItemOrder::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\PartnerRepositoryInterface::class,

            check_orm(\ErpNET\App\Models\Eloquent\Repositories\PartnerRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\PartnerRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\Partner::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\OrderRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\OrderRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\OrderRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\Order::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\CostAllocateRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\CostAllocateRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\CostAllocateRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\CostAllocate::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\ProductRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\ProductRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\ProductRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\Product::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\ProductGroupRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\ProductGroupRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\ProductGroupRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\ProductGroup::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\ProductProductGroupRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\ProductProductGroupRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\ProductProductGroupRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\ProductProductGroup::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\ProductSharedStatRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\ProductSharedStatRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\ProductSharedStatRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\ProductSharedStat::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\OrderSharedStatRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\OrderSharedStatRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\OrderSharedStatRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\OrderSharedStat::class
            ])
        );

        $this->app->bind(
            \ErpNET\App\Models\RepositoryLayer\SharedStatRepositoryInterface::class,
            check_orm(\ErpNET\App\Models\Eloquent\Repositories\SharedStatRepositoryEloquent::class,[
                'repository' => \ErpNET\App\Models\Doctrine\Repositories\SharedStatRepositoryDoctrine::class,
                'entity' => \ErpNET\App\Models\Doctrine\Entities\SharedStat::class
            ])
        );

    }
}
