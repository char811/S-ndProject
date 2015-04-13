<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.11.14
 * Time: 0:48
 */
namespace App\Session;

use Illuminate\Support\ServiceProvider;
use Session;

class CustomSessionServiceProvider extends ServiceProvider {

    public function register()
    {
        $connection = $this->app['config']['session.connection'];
        $table = $this->app['config']['session.table'];

        $this->app['session']->extend('database', function ($app) use ($connection, $table) {
            return new CustomDatabaseSessionHandler(
                $this->app['db']->connection($connection),
                $table
            );
        });
    }
}