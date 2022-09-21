<?php

namespace App\Http\Controllers\Gateway\Coingate;

use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use CoinGate\CoinGate;
use CoinGate\Merchant\Order;
use App\Http\Controllers\Gateway\PaymentController;

class ProcessController extends Controller
{
    /*
     * Coingate Gateway 505
     */

    public static function process($deposit)
    {
        $coingateAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);
        CoinGate::config(array(
            'environment' => 'live', // sandbox OR live
            'auth_token' => $coingateAcc->api_key
        ));

        $basic =  GeneralSetting::first();

        $post_params = array(
            'order_id' => $deposit->trx,
            'price_amount' => round($deposit->final_amo,2),
            'price_currency' => $deposit->method_currency,
            'receive_currency' => $deposit->method_currency,
            'callback_url' => route('ipn.'.$deposit->gateway->alias),
            'cancel_url' => route(gatewayRedirectUrl()),
            'success_url' => route(gatewayRedirectUrl(true)),
            'title' => 'Payment to ' . $basic->sitename,
            'token' => $deposit->trx
        );

        $order = Order::create($post_params);
        if ($order) {
            $send['redirect'] = true;
            $send['redirect_url'] = $order->payment_url;
        } else {
            $send['error'] = true;
            $send['message'] = 'Unexpected Error! Please Try Again';
        }
        $send['view'] = '';
        return json_encode($send);
    }

    public function ipn()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $validIp = curlContent('https://api.coingate.com/v2/ips-v4');
        if (strpos($validIp, $ip) !== false) {
            $deposit = Deposit::where('trx', $_POST['token'])->orderBy('id', 'DESC')->first();
            if ($_POST['status'] == 'paid' && $_POST['price_amount'] == $deposit->final_amo && $deposit->status == '0') {
                PaymentController::userDataUpdate($deposit->trx);
            }
        }
    }
}
