<?php
/**
 * 配置
 * Created by PhpStorm.
 * User: yutonghe
 * Date: 2017/9/28
 * Time: 16:00
 */
return [
    //国银
    'gy' => [
        //测试商户号和密钥
        'mchtId' => [
            'gymchtIdT0' => "1000001221", //线上二维码T0商户号,正式的交易的时候换成正式商户号
            'gymchtKeyT0' => "sLbAsG00RWs1eF13juevu5WfEFLDSe0c", //线上二维码T0商户密钥,正式的交易的时候换成正式商户密钥
        ],
        //线上二维码支付
        'qr_pay'=>[
            'getNativeUrl' => "http://112.74.25.79:9999/gyprovider/getNativeUrl.do",  //扫码支付接口
            'queryNativePayUrl' => "http://112.74.25.79:9999/gyprovider/queryNativePay.do",  //扫码支付查询接口
            'getJspayUrl' => 'http://112.74.25.79:9999/gyprovider/ getJspay.do',  //公众号支付初始化请求接口
        ],
        //代付
        'df_pay'=>[
            'singlePay' => " http://112.74.25.79:9999/gyprovider/daifu/singlePay.do",  //单笔代付
            'querySinglePay' => "http://112.74.25.79:9999/gyprovider/daifu/querySinglePay.do",  //单笔代付查询
            'queryAccount' => 'http://112.74.25.79:9999/gyprovider/daifu/queryAccount.do',  //账户余额查询
        ],
        //快捷支付
        'kj_pay' => [
            'prePay' => "http://112.74.25.79:9999/gyprovider/quickpay/prePay.do",  //快捷支付
            'checkPay' => "http://112.74.25.79:9999/gyprovider/quickpay/checkPay.do",  //快捷支付验证
            'queryPay' => 'http://112.74.25.79:9999/gyprovider/quickpay/queryPay.do',  //快捷交易查询
        ],
        //网银支付
        'wy_pay' => [
            'applyPay' => 'http://112.74.25.79:9999/gyprovider/netpay/applyPay.do', //预支付
            'queryPay' => 'http://112.74.25.79:9999/gyprovider/netpay/queryPay.do', //支付查询
        ]
    ],

    //聚成付
    'bjsm' => [
        //测试商户号和密钥
        'mchtId' => [
            'gymchtIdT0' => "bjsm00170003", //线上二维码T0商户号,正式的交易的时候换成正式商户号
            'gymchtKeyT0' => "4c9c719a69ac411c83e6556dee80d52c", //线上二维码T0商户密钥,正式的交易的时候换成正式商户密钥
        ],
        //线上二维码支付
        'qr_pay'=>[
            'getNativeUrl' => "http://103.230.242.81:8888/bjshuma/getNativeUrl.do",  //扫码支付接口
            'queryNativePayUrl' => "http://103.230.242.81:8888/bjshuma/queryNativePay.do",  //扫码支付查询接口
            'getJspayUrl' => 'http://103.230.242.81:8888/gyprovider/getJspay.do',  //公众号支付初始化请求接口
        ],
        //代付
        'df_pay'=>[
            'singlePay' => "http://103.230.242.81:8888/bjshuma/daifu/singlePay.do",  //单笔代付
            'querySinglePay' => "http://103.230.242.81:8888/bjshuma/daifu/querySinglePay.do",  //单笔代付查询
            'queryAccount' => 'http://103.230.242.81:8888/bjshuma/daifu/queryAccount.do',  //账户余额查询
        ],
        //快捷支付
        'kj_pay' => [
            'prePay' => "http://103.230.242.81:8888/bjshuma/quickpay/prePay.do",  //快捷支付
            'checkPay' => "http://103.230.242.81:8888/bjshuma/quickpay/checkPay.do",  //快捷支付验证
            'queryPay' => 'http://103.230.242.81:8888/bjshuma/quickpay/queryPay.do',  //快捷交易查询
        ],
        //网银支付
        'wy_pay' => [
            'applyPay' => 'http://103.230.242.81:8888/bjshuma/netpay/applyPay.do', //预支付
            'queryPay' => 'http://103.230.242.81:8888/bjshuma/netpay/queryPay.do', //支付查询
        ]
    ]
];