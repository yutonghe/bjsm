<?php
/**
 * 配置
 * Created by PhpStorm.
 * User: yutonghe
 * Date: 2017/9/28
 * Time: 16:00
 */
return [
    //测试商户号和密钥
    'mchtId' => [
        'gymchtIdT0' => "bjsm00170003", //线上二维码T0商户号,正式的交易的时候换成正式商户号
        'gymchtKeyT0' => "4c9c719a69ac411c83e6556dee80d52c", //线上二维码T0商户密钥,正式的交易的时候换成正式商户密钥
    ],
    //线上二维码支付
    'qr_code'=>[
        'getNativeUrl' => "http://103.230.242.81:8888/bjshuma/getNativeUrl.do",  //扫码支付接口
        'queryNativePayUrl' => "http://103.230.242.81:8888/gyprovider/queryNativePay.do",  //扫码支付查询接口
        'getJspayUrl' => 'http://103.230.242.81:8888/gyprovider/getJspay.do',  //公众号支付初始化请求接口
    ],
];