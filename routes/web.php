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
    return $router->app->version();
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
});


