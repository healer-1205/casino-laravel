<?php

namespace App\Http\Controllers\Gateway\Blockio;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\Blockio\BlockIo;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\Deposit;

class ProcessController extends Controller
{
    /*
     * BlockIO Pay Gateway
     */

    public static function process($deposit)
    {
        $blockIoAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);

        $apiKey = $blockIoAcc->api_key;
        $version = 2;
        $pin = $blockIoAcc->api_pin;
        $block_io = new BlockIo($apiKey, $pin, $version);

        if ($deposit->btc_amo == 0 || $deposit->btc_wallet == "") {


                $btcdata = $block_io->get_current_price(array('price_base' => 'USD'));
                if ($btcdata->status != 'success') {
                    $send['error'] = true;
                    $send['message'] = 'Failed to process with api';
                }
                $btcrate = $btcdata->data->prices[0]->price;
                $usd = $deposit->final_amo;
                $bcoin = round($usd / $btcrate, 8);

            $ad = $block_io->get_new_address();
            if ($ad->status == 'success') {
                $blockad = $ad->data;
                $wallet = $blockad->address;
                $deposit['btc_wallet'] = $wallet;
                $deposit['btc_amo'] = $bcoin;
                $deposit->update();
            } else {
                $send['error'] = true;
                $send['message'] = 'Failed to process with api';
            }
        }
        $send['amount'] = $deposit->btc_amo;
        $send['sendto'] = $deposit->btc_wallet;
        $send['img'] = cryptoQR($deposit->btc_wallet);
        $send['currency'] = "$deposit->method_currency";
        $send['view'] = 'user.payment.crypto';
        return json_encode($send);
    }

    public function ipn()
    {
        $deposits = Deposit::where('status', 0)->where('method_code', 502)->where('try', '<=', 100)->where('btc_amo', '>', 0)->where('btc_wallet', '!=', '')->orderBy('id','desc')->get();

        foreach ($deposits as $deposit) {

            $blockIoAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);
            $apiKey = $blockIoAcc->api_key;
            $version = 2;
            $pin = $blockIoAcc->api_pin;
            $block_io = new BlockIo($apiKey, $pin, $version);
            $balance = $block_io->get_address_balance(array('addresses' => $deposit->btc_wallet));

            echo '[' . $deposit->method_currency . '] - ' . $balance->data->available_balance . ' ---- ' . $deposit->btc_wallet . '<br>';

            if (@$balance->data->available_balance >= $deposit->btc_amo && $deposit->status == '0') {
                PaymentController::userDataUpdate($deposit->trx);
            }
            $deposit['try'] = $deposit->try + 1;
            $deposit->update();
        }

        echo '<br><br><br><br>RUNNING';
    }
}
