<?php
/**
 * 扫码支付控制器
 * Created by PhpStorm.
 * User: yutonghe
 * Date: 2017/9/28
 * Time: 14:00
 */

namespace App\Http\Controllers\Qrpay;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrpayController extends Controller
{

    //扫码支付
    public function qr_pay(){
        $url = Config::get("common.qr_code.getNativeUrl");
        $gymcht = Config::get("common.mchtId.gymchtIdT0");
        $key = Config::get("common.mchtId.gymchtKeyT0");
        $tradeSn = date('YmdHis').rand(1000, 9999);
        $postData = [
            'gymchtId' => $gymcht,
            'tradeSn' => $tradeSn,
            'orderAmount' => 1,
            'goodsName' => '扫码支付测试',
            'expirySecond' => 500,
            'tradeSource' => '2',
            'notifyUrl' => 'http://bjsm.com/twoPay',
            't0Flag' => '1',
        ];
        $postData['sign'] = get_sign($postData, $key);
        $result = create_request($url, $postData);
        $code = '';
        if($result['resultCode'] == '0000'){
           $code = QrCode::size(300)->generate($result['code_url']);
        }
        return view("Qrpay.test")->with("result", $result)->with('code', $code);
    }

    //交易查询
    public function queryNativePay(){
        $url = Config::get("common.qr_code.queryNativePayUrl");
        $gymcht = Config::get("common.mchtId.gymchtIdT0");
        $key = Config::get("common.mchtId.gymchtKeyT0");
        $tradeSn = '1000001221_bjsm19';
        $postData = [
            'gymchtId' => $gymcht,
            'tradeSn' => $tradeSn,
            'orderAmount' => 1,
        ];
        $postData['sign'] = get_sign($postData, $key);
        $result = create_request($url, $postData);
        if($result['resultCode'] == '0000'){
            switch($result['tradeState']){
                case 'SUCCESS':
                    $result['tradeStateName'] = '支付成功';
                    break;
                case 'REFUND':
                    $result['tradeStateName'] = '转入退款';
                    break;
                case 'REFUND':
                    $result['tradeStateName'] = '转入退款';
                    break;
                case 'NOTPAY':
                    $result['tradeStateName'] = '未支付';
                    break;
                case 'CLOSED':
                    $result['tradeStateName'] = '已关闭';
                    break;
                case 'PAYERROR':
                    $result['tradeStateName'] = '支付失败';
                    break;
            }
        }
        return view("Qrpay.queryNativePay")->with("result", $result);
    }

    //扫码通知

}
