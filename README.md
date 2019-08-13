# Xorpay SDK

## 安装

```bash
composer require xorpay/sdk
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
