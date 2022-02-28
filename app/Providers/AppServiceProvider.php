<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Providers\Braintree_Configuration;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

         $environment = env('BRAINTREE_ENV');

        /* live
        $braintree = new \Braintree\Gateway([
            'environment' => 'production',
            'merchantId' => 'jxj433gk7vj8thzr',
            'publicKey' => '94ydmqygyxkjpt8t',
            'privateKey' => '012907436ebbd619f67c452109a6e0a3'
        ]); */
        // testing
        $braintree = new \Braintree\Gateway([
            'environment' => env('BTREE_ENVIRONMENT'),
            'merchantId' => env('BTREE_MERCHANT_ID'),
            'publicKey' => env('BTREE_PUBLIC_KEY'),
            'privateKey' =>env('BTREE_PRIVATE_KEY')
        ]);
        config(['braintree' => $braintree]);
       
    }
}
