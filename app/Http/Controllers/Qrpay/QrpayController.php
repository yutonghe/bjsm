<?php
/**
 * 扫码支付
 * Created by PhpStorm.
 * User: yutonghe
 * Date: 2017/9/28
 * Time: 14:00
 */

namespace App\Http\Controllers\Qrpay;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrpayController extends Controller
{

    //扫码支付
    public function qrpay(){
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
            'notifyUrl' => 'http://bjsm.com/getQrNotify',
            't0Flag' => '1',
        ];
        $postData['sign'] = getSign($postData, $key);
        $result = create_request($url, $postData);
        $code = '';
        if($result['resultCode'] == '0000'){
            if(!isGySign($result,$key,$result['sign'])){
                $result['resultCode'] = '5001';
                $result['message'] = '数字签名错误';
            }else{
                $code = QrCode::size(300)->generate($result['code_url']);
            }
        }
        return view("Qrpay.test")->with("result", $result)->with('code', $code);
    }

    //交易查询
    public function queryNativePay(){
        $url = Config::get("common.qr_code.queryNativePayUrl");
        $gymcht = Config::get("common.mchtId.gymchtIdT0");
        $key = Config::get("common.mchtId.gymchtKeyT0");
        $tradeSn = '1000001221_bjsm20';
        $postData = [
            'gymchtId' => $gymcht,
            'tradeSn' => $tradeSn,
            'orderAmount' => 1,
        ];
        $postData['sign'] = getSign($postData, $key);
        $result = create_request($url, $postData);
        if($result['resultCode'] == '0000'){
            if(!isGySign($result,$key,$result['sign'])){
                $result['resultCode'] = '5001';
                $result['message'] = '数字签名错误';
            }else{
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
        }
        return view("Qrpay.queryNativePay")->with("result", $result);
    }

    //扫码通知处理
    public function getQrNotify(Request $request){
        $data = [
            'gymchtId' => $request->input('gymchtId'),
            'transaction' => $request->input('transaction'),
            'tradeSn' => $request->input('tradeSn'),
            'pay_result' => $request->input('pay_result'),
            'pay_info' => $request->input('pay_info'),
            'orderAmount' => $request->input('orderAmount'),
            'coupon_fee' => $request->input('coupon_fee'),
            'bankType' => $request->input('bankType'),
            'timeEnd' => $request->input('timeEnd'),
            'sign' => $request->input('sign'),
            't0Flag' => $request->input('t0Flag'),
            't0RespCode' => $request->input('t0RespCode'),
            't0RespDesc' => $request->input('t0RespDesc'),
        ];
        if($request->input('t0Flag') == 1){
            $data['t0_status'] = $request->input('t0_status');
            $data['t0RespCode'] = $request->input('t0RespCode');
            $data['t0RespDesc'] = $request->input('t0RespDesc');
        }
        $key = Config::get("common.mchtId.gymchtKeyT0");
        if(isGySign($data,$key,$data['sign'])){
            return 'suceess';
        }else{
            return 'false';
        }
    }
}
