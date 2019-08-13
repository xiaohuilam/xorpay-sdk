<?php
namespace Xorpay;

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Arr;

class Xorpay
{
    /**
     * 发起支付
     *
     * @param array $data
     * @param string $pay_type 支付方式native/alipay
     */
    public function requestPay($data, $pay_type = 'native')
    {
        $base_string = data_get($data, 'name') . $pay_type . data_get($data, 'price') . data_get($data, 'order_id') . data_get($data, 'notify_url') . config('xorpay.app_secret');
        data_set($data, 'sign', md5($base_string));
        data_set($data, 'pay_type', $pay_type);

        $http = new Client();
        $response = $http->post('https://xorpay.com/api/pay/' . config('xorpay.aid'), [
            'form_params' => Arr::only((array) $data, ['name', 'price', 'order_id', 'order_uid', 'notify_url', 'sign', 'pay_type',]),
        ]);

        return json_decode($response->getBody()->__toString());
    }

    /**
     * 回调处理
     *
     * @param \Closure $success 成功的逻辑，会传订单id进去
     */
    public function notifyOrder($success)
    {
        $data = [
            request()->input('aoid'),
            request()->input('order_id'),
            request()->input('pay_price'),
            request()->input('pay_time'),
            config('xorpay.app_secret'),
        ];

        $sign = md5(join('', $data));

        if ($sign != request()->input('sign')) {
            abort(400, 'Bad sign');
        }

        call_user_func_array($success, [request()->input('order_id')]);

        return response('ok');
    }
}
