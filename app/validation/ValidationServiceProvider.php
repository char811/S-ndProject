<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21.11.14
 * Time: 16:07
 */
namespace App\Validation;

use Illuminate\Support\ServiceProvider;


 class ValidationServiceProvider extends ServiceProvider {

    public function register() {
        // nothing yet
    }

    public function boot() {
        $this->app->validator->resolver(function($translator, $data, $rules, $messages) {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }

}
