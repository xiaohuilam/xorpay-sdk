<?php
namespace Xorpay;

use Illuminate\Support\ServiceProvider;

class XorpayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('xorpay.php'),
        ], 'xorpay');

        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'xorpay');

        app()->singleton('xorpay', function () {
            return app(Xorpay::class);
        });
    }
}
