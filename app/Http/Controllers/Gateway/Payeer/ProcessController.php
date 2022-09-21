<?php

namespace App\Http\Controllers\Gateway\Payeer;

use App\Models\Deposit;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    /*
     * Payeer Gateway
     */

    public static function process($deposit)
    {
        $PayeerAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);
        $basic =  GeneralSetting::first();
        $val['m_shop'] = trim($PayeerAcc->merchant_id);
        $val['m_orderid'] = $deposit->trx;
        $val['m_amount'] = number_format($deposit->final_amo, 2, '.', '');
        $val['m_curr'] = $deposit->method_currency;
        $val['m_desc'] = base64_encode("Pay To $basic->sitename");
        $arHash = [$val['m_shop'], $val['m_orderid'], $val['m_amount'], $val['m_curr'], $val['m_desc']];
        $arHash[] = $PayeerAcc->secret_key;
        $val['m_sign'] = strtoupper(hash('sha256', implode(":", $arHash)));
        $send['val'] = $val;
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'get';
        $send['url'] = 'https://payeer.com/merchant';

        return json_encode($send);
    }


    public function ipn(Request $request)
    {
        if (isset($_POST["m_operation_id"]) && isset($_POST["m_sign"])) {

            $deposit = Deposit::where('trx', $_POST['m_orderid'])->orderBy('id', 'DESC')->first();
            $PayeerAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);
            $sign_hash = strtoupper(hash('sha256', implode(":", array(
                $_POST['m_operation_id'],
                $_POST['m_operation_ps'],
                $_POST['m_operation_date'],
                $_POST['m_operation_pay_date'],
                $_POST['m_shop'],
                $_POST['m_orderid'],
                $_POST['m_amount'],
                $_POST['m_curr'],
                $_POST['m_desc'],
                $_POST['m_status'],
                $PayeerAcc->secret_key
            ))));

            if ($_POST["m_sign"] != $sign_hash) {
                $notify[] = ['error', 'The digital signature did not matched.'];
            } else {
                if ($_POST['m_amount'] == getAmount($deposit->final_amo) && $_POST['m_curr'] == $deposit->method_currency && $_POST['m_status'] == 'success' && $deposit->status == '0') {
                    PaymentController::userDataUpdate($deposit->trx);
                    $notify[] = ['success', 'Transaction is successful'];
                    return redirect()->route(gatewayRedirectUrl(true))->withNotify($notify);
                } else {
                    $notify[] = ['error', 'Payment failed.'];
                }
            }
        } else {
            $notify[] = ['error', 'Payment failed.'];
        }
        return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
    }
}
