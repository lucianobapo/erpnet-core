<?php
/**
 * Created by PhpStorm.
 * User: luciano
 * Date: 26/04/16
 * Time: 20:40
 */

namespace ErpNET\Tests\Classes\Traits;


use ErpNET\App\Providers\ErpnetServiceProvider;
use LaravelDoctrine\Extensions\GedmoExtensionsServiceProvider;
use LaravelDoctrine\ORM\DoctrineServiceProvider;
use PDO;

trait TestPrepare
{
    protected $testFieldsSignature = null;

    public function loadSignatures(){
        
    }

    public function loadRegisterProviders(){
        $this->app->register(ErpnetServiceProvider::class);
        $this->app->register(DoctrineServiceProvider::class);
        $this->app->register(GedmoExtensionsServiceProvider::class);
    }

    public function loadRepo(){
        if (!is_null($this->app) && !is_null($this->testClass) && is_null($this->repo)) {
            try {

                $this->repo = $this->app->make($this->testClass);
            } catch (\Exception $e) {
                $message = 'Failed to load repo: '.get_class($this).' - '.$e->getMessage();
                throw new \Exception($message);
                $this->repo = null;
            }
        }
    }

    public function loadService(){
        if (!is_null($this->app) && !is_null($this->testServiceClass) && is_null($this->service)) {
            try {
                $this->service = $this->app->make($this->testServiceClass);
            } catch (\Exception $e) {
                $this->service = null;
                $message = 'Failed to load service: '.get_class($this).' - '.$e->getMessage();
                throw new \RuntimeException($message);
            }
        }
    }

    public function loadCustomConfig(){
        config(['erpnet.orm'=> 'doctrine']);
//        config(['erpnet.orm'=> 'eloquent']);

//        config(['doctrine.managers.default.connection'=> 'sqlite']);
//        config(['database.default'=> 'sqlite']);

        config(['doctrine.managers.default.connection'=> 'mysql']);
        config(['database.default'=> 'mysql']);

//        config(['doctrine.managers.default.connection'=> 'sqlite_testing']);
//        config(['database.default'=> 'sqlite_testing']);
        $this->loadEnviroment();
    }



    public function loadConfig(){
        // Config for auth
        config([
            'auth' => [
                'defaults' => [
                    'guard' => 'web',
                    'passwords' => 'users',
                ],
                'guards' => [
                    'web' => [
                        'driver' => 'session',
                        'provider' => 'users',
                    ],
                    'api' => [
                        'driver' => 'token',
                        'provider' => 'users',
                    ],
                ],
                'providers' => [
                    'users' => [
                        'driver' => 'eloquent',
                        'model' => App\User::class,
                    ],
                ],
                'passwords' => [
                    'users' => [
                        'provider' => 'users',
                        'email' => 'auth.emails.password',
                        'table' => 'password_resets',
                        'expire' => 60,
                    ],
                ],
            ],
        ]);

        // config for database
        config(['database'=>[
            'fetch' => PDO::FETCH_CLASS,
            'default' => 'sqlite_testing',
            'connections' => [
                'sqlite' => [
                    'driver'   => 'sqlite',
                    'database' => database_path('database.sqlite'),
                    'prefix'   => '',
                ],
                'sqlite_testing' => array(
                    'driver'   => 'sqlite',
                    'database' => ':memory:',
                    'prefix'   => '',
                ),
                'mysql' => [
                    'driver'    => 'mysql',
                    'host'      => env('DB_HOST', 'localhost'),
                    'database'  => env('DB_DATABASE', 'forge'),
                    'username'  => env('DB_USERNAME', 'forge'),
                    'password'  => env('DB_PASSWORD', ''),
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                    'strict'    => false,
                ],
            ],
            'migrations' => 'migrations',
        ]
        ]);

        config([
            'doctrine' => [
                /*
                |--------------------------------------------------------------------------
                | Entity Mangers
                |--------------------------------------------------------------------------
                |
                | Configure your Entity Managers here. You can set a different connection
                | and driver per manager and configure events and filters. Change the
                | paths setting to the appropriate path and replace App namespace
                | by your own namespace.
                |
                | Available meta drivers: fluent|annotations|yaml|xml|config|static_php
                |
                | Available connections: mysql|oracle|pgsql|sqlite|sqlsrv
                | (Connections can be configured in the database config)
                |
                | --> Warning: Proxy auto generation should only be enabled in dev!
                |
                */
                'managers'                  => [
                    'default' => [
                        'dev'        => env('APP_DEBUG'),
                        'meta'       => env('DOCTRINE_METADATA', 'annotations'),
                        'connection' => env('DB_CONNECTION', 'mysql'),
                        'namespaces' => [
                            'ErpNET\App'
                        ],
                        'paths'      => [
                            base_path('src')
                        ],
                        'repository' => \Doctrine\ORM\EntityRepository::class,
                        'proxies'    => [
                            'namespace'     => false,
                            'path'          => storage_path('proxies'),
                            'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', true)
                        ],
                        /*
                        |--------------------------------------------------------------------------
                        | Doctrine events
                        |--------------------------------------------------------------------------
                        |
                        | The listener array expects the key to be a Doctrine event
                        | e.g. Doctrine\ORM\Events::onFlush
                        |
                        */
                        'events'     => [
                            'listeners'   => [],
                            'subscribers' => []
                        ],
                        'filters'    => [],
                        /*
                        |--------------------------------------------------------------------------
                        | Doctrine mapping types
                        |--------------------------------------------------------------------------
                        |
                        | Link a Database Type to a Local Doctrine Type
                        |
                        | Using 'enum' => 'string' is the same of:
                        | $doctrineManager->extendAll(function (\Doctrine\ORM\Configuration $configuration,
                        |         \Doctrine\DBAL\Connection $connection,
                        |         \Doctrine\Common\EventManager $eventManager) {
                        |     $connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
                        | });
                        |
                        | References:
                        | http://doctrine-orm.readthedocs.org/en/latest/cookbook/custom-mapping-types.html
                        | http://doctrine-dbal.readthedocs.org/en/latest/reference/types.html#custom-mapping-types
                        | http://doctrine-orm.readthedocs.org/en/latest/cookbook/advanced-field-value-conversion-using-custom-mapping-types.html
                        | http://doctrine-orm.readthedocs.org/en/latest/reference/basic-mapping.html#reference-mapping-types
                        | http://symfony.com/doc/current/cookbook/doctrine/dbal.html#registering-custom-mapping-types-in-the-schematool
                        |--------------------------------------------------------------------------
                        */
                        'mapping_types'              => [
                            //'enum' => 'string'
                        ]
                    ]
                ],
                /*
                |--------------------------------------------------------------------------
                | Doctrine Extensions
                |--------------------------------------------------------------------------
                |
                | Enable/disable Doctrine Extensions by adding or removing them from the list
                |
                | If you want to require custom extensions you will have to require
                | laravel-doctrine/extensions in your composer.json
                |
                */
                'extensions'                => [
                    //LaravelDoctrine\ORM\Extensions\TablePrefix\TablePrefixExtension::class,
                    \LaravelDoctrine\Extensions\Timestamps\TimestampableExtension::class,
                    \LaravelDoctrine\Extensions\SoftDeletes\SoftDeleteableExtension::class,
//                    \ErpNET\App\Models\Doctrine\Extensions\MandanteExtension::class,
//                    LaravelDoctrine\Extensions\Sluggable\SluggableExtension::class,
                    //LaravelDoctrine\Extensions\Sortable\SortableExtension::class,
                    //LaravelDoctrine\Extensions\Tree\TreeExtension::class,
                    //LaravelDoctrine\Extensions\Loggable\LoggableExtension::class,
                    //LaravelDoctrine\Extensions\Blameable\BlameableExtension::class,
                    //LaravelDoctrine\Extensions\IpTraceable\IpTraceableExtension::class,
                    //LaravelDoctrine\Extensions\Translatable\TranslatableExtension::class
                ],
                /*
                |--------------------------------------------------------------------------
                | Doctrine custom types
                |--------------------------------------------------------------------------
                |
                | Create a custom or override a Doctrine Type
                |--------------------------------------------------------------------------
                */
                'custom_types'              => [
                    'json' => \LaravelDoctrine\ORM\Types\Json::class
                ],
                /*
                |--------------------------------------------------------------------------
                | DQL custom datetime functions
                |--------------------------------------------------------------------------
                */
                'custom_datetime_functions' => [],
                /*
                |--------------------------------------------------------------------------
                | DQL custom numeric functions
                |--------------------------------------------------------------------------
                */
                'custom_numeric_functions'  => [],
                /*
                |--------------------------------------------------------------------------
                | DQL custom string functions
                |--------------------------------------------------------------------------
                */
                'custom_string_functions'   => [],
                /*
                |--------------------------------------------------------------------------
                | Enable query logging with laravel file logging,
                | debugbar, clockwork or an own implementation.
                | Setting it to false, will disable logging
                |
                | Available:
                | - LaravelDoctrine\ORM\Loggers\LaravelDebugbarLogger
                | - LaravelDoctrine\ORM\Loggers\ClockworkLogger
                | - LaravelDoctrine\ORM\Loggers\FileLogger
                |--------------------------------------------------------------------------
                */
                'logger'                    => env('DOCTRINE_LOGGER', false),
                /*
                |--------------------------------------------------------------------------
                | Cache
                |--------------------------------------------------------------------------
                |
                | Configure meta-data, query and result caching here.
                | Optionally you can enable second level caching.
                |
                | Available: acp|array|file|memcached|redis|void
                |
                */
                'cache'                     => [
                    'default'                => env('DOCTRINE_CACHE', 'array'),
                    'namespace'              => null,
                    'second_level'           => false,
                ],
                /*
                |--------------------------------------------------------------------------
                | Gedmo extensions
                |--------------------------------------------------------------------------
                |
                | Settings for Gedmo extensions
                | If you want to use this you will have to require
                | laravel-doctrine/extensions in your composer.json
                |
                */
                'gedmo'                     => [
                    'all_mappings' => false
                ],
            ],
        ]);

        $this->loadCustomConfig();
    }

    protected function loadEnviroment()
    {
        $filename = base_path('tests/enviroment/') . str_slug(get_class($this) . $this->getName()) . '.txt';
        if (!file_exists($filename)) {
            $myfile = fopen($filename, "w") or die("Unable to open file!");
            $txt = config('erpnet.orm');
            fwrite($myfile, $txt);
            fclose($myfile);
        } else {
            $myfile = fopen($filename, "r") or die("Unable to open file!");
            $txt = fgets($myfile);
            fclose($myfile);
            if ($txt == 'doctrine') {
                config(['erpnet.orm' => 'eloquent']);
                $myfile = fopen($filename, "w") or die("Unable to open file!");
                fwrite($myfile, 'eloquent');
                fclose($myfile);
            } elseif ($txt == 'eloquent') {
                config(['erpnet.orm' => 'doctrine']);
                $myfile = fopen($filename, "w") or die("Unable to open file!");
                fwrite($myfile, 'doctrine');
                fclose($myfile);
            }
        }
//        var_dump('Running tests for ' . config('erpnet.orm') . ' - ' . get_class($this) . ': ' . $this->getName());
    }

    protected function factoryTestClass($arguments = null)
    {
        $record = factory_orm_create($this->testClass, $arguments);
        $repoPartner = $this->app->make($this->testClass);
        if (!isset($repoPartner->table)) {
            $this->markTestSkipped(
                "No table - ".get_class($repoPartner)
            );
        }
        $instance = $repoPartner->model;
        if (!is_string($instance)) $instance = get_class($instance);
        $this->assertInstanceOf($instance, $record);
        $this->assertEquals($repoPartner->find($record->id)->id,$record->id);

        return $record;
    }
}