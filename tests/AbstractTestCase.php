<?php
namespace Xorpay\Test;

use Illuminate\Support\Str;
use XiaohuiLam\Laravel\Test\TestCase;
use Xorpay\Facade;
use Xorpay\XorpayServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /**
         * @var \Illuminate\Foundation\Application $app
         */
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Xorpay', Facade::class);
        });
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $app->register(XorpayServiceProvider::class);
        return $app;
    }
}
