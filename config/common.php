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
        'gymchtIdT0' => "1000001221", //国银分配的线上二维码T0商户号,正式的交易的时候换成正式商户号
        'gymchtKeyT0' => "sLbAsG00RWs1eF13juevu5WfEFLDSe0c", //国银分配的线上二维码T0商户密钥,正式的交易的时候换成正式商户密钥
        'gymchtIdT1' => "1000001234",//国银分配的线上二维码T1商户号,正式的交易的时候换成正式商户号
        'gymchtKeyT1' => "vvSRvJnldOtUZpTb49DL0rFhzLSGVbLA", //国银分配的线上二维码T1商户密钥,正式的交易的时候换成正式商户密钥
    ],
    //线上二维码支付
    'qr_code'=>[
        'getNativeUrl' => "http://112.74.25.79:9999/gyprovider/getNativeUrl.do",  //扫码支付接口
        'queryNativePayUrl' => "http://112.74.25.79:9999/gyprovider/queryNativePay.do",  //扫码支付查询接口
        'getJspayUrl' => 'http://112.74.25.79:9999/gyprovider/getJspay.do',  //公众号支付初始化请求接口
    ],
];