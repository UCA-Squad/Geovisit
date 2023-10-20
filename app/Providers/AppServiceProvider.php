<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Http\Validators\CustomValidationRules;

class AppServiceProvider extends ServiceProvider {

    /**

     * Bootstrap any application services.

     *

     * @return void

     */
    public function boot() {

        Validator::resolver(fn($translator, $data, $rules, $messages) => new CustomValidationRules($translator, $data, $rules, $messages));
        
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }

    /**

     * Register any application services.

     *

     * @return void

     */
    public function register() {

        //
    }

}
