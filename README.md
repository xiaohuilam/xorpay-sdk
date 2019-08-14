# Xorpay SDK

[XorPay](https://xorpay.com?r=register)是提供个人微信、支付宝收款的在线工具，费率从0.9%~1.38%。[了解一下](https://xorpay.com?r=register
)


## 安装
**依赖**
- php 5.6 +
- laravel 5.0 +

```bash
composer require xorpay/sdk
```

**如果Laravel低于5.5**, 需要手工添加服务提供者和别名

打开 `config/app.php`

```php
'providers' => [
    //...
    Xorpay\XorpayServiceProvider::class,
],
'aliases' => [
    //...
    'Xorpay' => Xorpay\Facade::class,
],
```

## 配置

添加 env

```env
XORPAY_AID=#你的AID
XORPAY_APP_SECRET=#你的KEY
```

## 使用
**发起支付**
```php
app('xorpay')->requestPay([
    'name' => '订单名字',
    'price' => 200,
    'order_id' => 12,
    'order_uid' => 1,
    'notify_url' => route('pay.notify', $order), //回调路由
], 'native')
```

**回调**
```php
// 当验签不通过，自动报失败，而不会执行成功的逻辑
app('xorpay')->notifyOrder(function ($order_id) {
    $order = Order::findOrFail($order_id);
    $order->status = Order::STATUS_PAID;
    $order->save();
})
```

## 授权
MIT
