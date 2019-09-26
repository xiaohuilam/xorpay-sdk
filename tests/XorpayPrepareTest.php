<?php
namespace Xorpay\Test;

use Illuminate\Support\Str;
use Xorpay\Facade;
use Xorpay\XorpayServiceProvider;

class XorpayPrepareTest extends AbstractTestCase
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

    /**
     * 测试支付
     *
     * @return void
     */
    public function testPrepare()
    {
        $data = [
            'name' => Str::random(),
            'price' => mt_rand(100, 200),
            'order_id' => Str::random(),
            'order_uid' => 1,
            'notify_url' => 'https://www.baidu.com/',
            'pay_type' => 'native',
        ];

        Facade::shouldReceive('requestPay', [
            $data,
            'native'
        ])->andReturn(json_decode('{"status":"ok","info":{"qr":"weixin:\/\/wxpay\/bizpayurl?pr=KGdA4v4"},"expires_in":7200,"aoid":"e19c8c8673ba42419043fc92b99303c1","paid":false,"success":true}'));

        $pay = Facade::requestPay($data, 'native');
        $this->assertEquals('weixin://wxpay/bizpayurl?pr=KGdA4v4', $pay->info->qr);
    }
}
