<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect('index');
});

//二维碼支付
$router->group(['namespace' => 'Qrpay'], function() use ($router) {
    //扫码支付
    $router->get('/qr_pay', [
        'as' => 'Qrpay.qr_pay', 'uses' => 'QrpayController@qrpay',
    ]);
    //交易查询
    $router->get('/qr_info', [
        'as' => 'Qrpay.qr_info', 'uses' => 'QrpayController@queryNativePay',
    ]);
    //扫码支付通知处理
    $router->post('/qr_notify', [
        'as' => 'Qrpay.qr_notify', 'uses' => 'QrpayController@getQrNotify',
    ]);

    //单笔代付
    $router->get('/df_pay', [
        'as' => 'Qrpay.df_pay', 'uses' => 'QrpayController@ondf_pay',
    ]);
    //代付查询
    $router->get('/df_query_pay', [
        'as' => 'Qrpay.df_query_pay', 'uses' => 'QrpayController@df_query_pay',
    ]);
    //代付余额查询
    $router->get('/df_query', [
        'as' => 'Qrpay.df_query', 'uses' => 'QrpayController@df_query',
    ]);

    //快捷支付
    $router->get('/kj_pay', [
        'as' => 'Qrpay.kj_pay', 'uses' => 'QrpayController@kj_pay',
    ]);

    //网银支付
    $router->get('/apply_pay', [
        'as' => 'Qrpay.apply_pay', 'uses' => 'QrpayController@apply_pay',
    ]);
});

//门户网站
$router->group(['namespace' => 'Company'], function() use ($router) {
    //首页
    $router->get('/index', [
        'as' => 'Index.index', 'uses' => 'IndexController@index',
    ]);
});

//门户网站
$router->group(['namespace' => 'Company'], function() use ($router) {
    //首页
    $router->get('/index', [
        'as' => 'Index.index', 'uses' => 'IndexController@index',
    ]);
});




