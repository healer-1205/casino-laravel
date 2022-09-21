<?php

namespace App\Http\Controllers\Gateway\Blockchain;

use App\Models\Deposit;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;

class ProcessController extends Controller
{
    /*
     * Blockchain Pay Gateway
     */

    public static function process($deposit)
    {
        $blockchainAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);

        $all = curlContent("https://blockchain.info/ticker");
        $res = json_decode($all);
        $btcrate = $res->USD->last;

        $usd = $deposit->final_amo;
        $btcamount = $usd / $btcrate;
        $btc = round($btcamount, 8);

        $deposit = Deposit::where('trx', $deposit->trx)->orderBy('id', 'DESC')->first();


        if ($deposit->btc_amo == 0 || $deposit->btc_wallet == "") {
            $blockchain_receive_root = "https://api.blockchain.info/";
            $secret = "MySecret";
            $my_xpub = trim($blockchainAcc->xpub_code);
            $my_api_key = trim($blockchainAcc->api_key);
            $invoice_id = $deposit->trx;
            $callback_url = route('ipn.'.$deposit->gateway->alias) . "?invoice_id=" . $invoice_id . "&secret=" . $secret;
            $resp = curlContent($blockchain_receive_root . "v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" . $my_xpub);
            $response = json_decode($resp);
            if (@$response->address == '') {
                $send['error'] = true;
                $send['message'] = 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER. ' . $response->message;
            } else {

                $sendto = $response->address;
                $deposit['btc_wallet'] = $sendto;
                $deposit['btc_amo'] = $btc;
                $deposit->update();
            }
        }
        $deposit = Deposit::where('trx', $deposit->trx)->orderBy('id', 'DESC')->first();
        $send['amount'] = $deposit->btc_amo;
        $send['sendto'] = $deposit->btc_wallet;
        $send['img'] = cryptoQR($deposit->btc_wallet);
        $send['currency'] = "BTC";
        $send['view'] = 'user.payment.crypto';
        return json_encode($send);
    }

    public function ipn()
    {
        $track = $_GET['invoice_id'];
        $value_in_btc = $_GET['value'] / 100000000;
        
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        
        foreach ($_GET as $key => $value) {
            $details[$key] = $value;
        }
        $deposit->detail = $details;
        $deposit->save();
        
        if ($deposit->btc_amo == $value_in_btc && $_GET['address'] == $deposit->btc_wallet && $_GET['secret'] == "MySecret" && $_GET['confirmations'] > 2 && $deposit->status == 0) {
            PaymentController::userDataUpdate($deposit->trx);
        }
    }
}
