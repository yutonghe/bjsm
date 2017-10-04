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
    private $conf = 'bjsm';

    //扫码支付
    public function qrpay(){
        $url = Config::get("common.". $this->conf .".qr_pay.getNativeUrl");
        $gymcht = Config::get("common.". $this->conf .".mchtId.gymchtIdT0");
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        $tradeSn = date('YmdHis').rand(1000, 9999);
        $postData = [
            'gymchtId' => $gymcht,
            'tradeSn' => $tradeSn,
            'orderAmount' => 1,
            'goodsName' => '扫码支付测试',
            'expirySecond' => 500,
            'tradeSource' => '2',
            'notifyUrl' => 'http://1860z45q02.51mypc.cn:11345/bjsm/public/getQrNotify',
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
        $url = Config::get("common.". $this->conf .".qr_pay.queryNativePayUrl");
        $gymcht = Config::get("common.". $this->conf .".mchtId.gymchtIdT0");
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        $tradeSn = '1000001221_bjsm20';
        $postData = [
            'gymchtId' => $gymcht,
            'tradeSn' => $tradeSn,
            'orderAmount' => 1,
        ];
        $postData['sign'] = getSign($postData, $key);
        $result = create_request($url, $postData);
        //dd($result);
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
        $rs = file_get_contents("php://input");
        $rs = json_decode($rs, true);
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        if(isGySign($rs,$key,$rs['sign']))
        {
            if($rs['pay_result'] == '0'){//0-成功 其他-失败
                //更改订单状态;notify_url 有可能重复通知,商户系统需要做去重处理,避免多次发货

                echo "success";
                exit();
            }else{
                echo "failure";
                exit();
            }
        }else{
            echo "failure";
        }
    }

    //公众号支付
    public function gzh_pay(){

    }

    //单笔代付
    public function ondf_pay(){
        $url = Config::get("common.". $this->conf .".df_pay.singlePay");
        $gymcht = Config::get("common.". $this->conf .".mchtId.gymchtIdT0");
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        $postData = [
            'gymchtId' => $gymcht,
            'dfSn' => getRandomStr(),
            'receiptAmount' => 1,
            'curType' => '1',
            'payType' => '2',
            'receiptName' => '余统和',
            'receiptPan' => '6214837846493702',
            'receiptBankNm' => '招商银行',
            'settleNo' => '308584001792',
            'acctType' => '0',
            'mobile' => '15814695088',
            'nonce' => getRandomStr(),
        ];
        $postData['sign'] = getSign($postData, $key);
        //dd($postData);
        $result = create_request($url, $postData);
        dd($result);
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

    //代付查询
    public function df_query_pay(){
        $url = Config::get("common.". $this->conf .".df_pay.querySinglePay");
        $gymcht = Config::get("common.". $this->conf .".mchtId.gymchtIdT0");
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        $postData = [
            'gymchtId' => $gymcht,
            'dfSn' => 'd30054a06b97c89dc9e4f328461e90eb',
            'dfTransactionId' => '1',
            'nonce' => getRandomStr(),
        ];
        $postData['sign'] = getSign($postData, $key);
        $result = create_request($url, $postData);
        dd($result);
    }

    //余额查询
    public function df_query(){
        $url = Config::get("common.". $this->conf .".df_pay.queryAccount");
        $gymcht = Config::get("common.". $this->conf .".mchtId.gymchtIdT0");
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        $postData = [
            'gymchtId' => $gymcht,
            'qryTime' => date("YMDHIS"),
            'qryType' => '1',
            'nonce' => getRandomStr(),

        ];
        $postData['sign'] = getSign($postData, $key);
        $result = create_request($url, $postData);
        dd($result);
    }

    //快捷支付
    public function kj_pay(){
        $url = Config::get("common.". $this->conf .".kj_pay.prePay");
        $gymcht = Config::get("common.". $this->conf .".mchtId.gymchtIdT0");
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        $postData = [
            'gymchtId' => $gymcht,
            'tradeSn' => 'CS'.date('YmdHis').rand(1000,9999),
            'orderAmount' => 1,
            'cardHolderName' => '潘汉子',
            'cardNo' => '41007200040022583',
            'cardType' => '01',
            'bankName' => '中国农业银行',
            'cerType' => '01',
            'cerNumber' => '522423196303208325',
            'mobileNum' => '15814695088',
            'nonce' => getRandomStr(),
        ];
        $postData['sign'] = getSign($postData, $key);
        $result = create_request($url, $postData);
        dd($result);
    }

    //网银支付申请
    public function apply_pay(){
        $url = Config::get("common.". $this->conf .".wy_pay.applyPay");
        $gymcht = Config::get("common.". $this->conf .".mchtId.gymchtIdT0");
        $key = Config::get("common.". $this->conf .".mchtId.gymchtKeyT0");
        $postData = [
            'gymchtId' => $gymcht,
            'tradeSn' => 'CS'.date('YmdHis').rand(1000,9999),
            'orderAmount' => 13,
            'goodsName' => 'bjsm',
            'bankSegment' => '1002',
            'cardType' => '01',
            'notifyUrl' => 'http://1860z45q02.51mypc.cn:11345/bjsm/public/getQrNotify',
            'callbackUrl' => 'http://baidu.com',
            'channelType' => '1',
            'nonce' => getRandomStr(),
        ];
        $postData['sign'] = getSign($postData, $key);
        $result = create_request($url, $postData);
        dd($result);
    }

}
