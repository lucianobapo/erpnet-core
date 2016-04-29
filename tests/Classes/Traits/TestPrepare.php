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
            } catch (Exception $e) {
                var_dump(get_class($this));
                var_dump($e->getMessage());
                $this->repo = null;
//                throw $e;
            }
        }
    }

    public function loadCustomConfig(){
        config(['erpnet.orm'=> 'doctrine']);
//        config(['erpnet.orm'=> 'eloquent']);

        config(['doctrine.managers.default.connection'=> 'sqlite']);
        config(['database.default'=> 'sqlite']);

//        config(['doctrine.managers.default.connection'=> 'mysql']);
//        config(['database.default'=> 'mysql']);

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
}