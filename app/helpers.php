<?php
/**
 * 函数
 * Created by PhpStorm.
 * User: yutonghe
 * Date: 2017/9/28
 * Time: 14:00
 */

/**
 *      post方法请求
 *      @param      string      $url            server url
 *      @param      array       $postData       post数据
 *      @return     json        $rs            接口返回数据,此demo中为返回json数据
 */
if (!function_exists('create_request')) {
    function create_request($url, $postData)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            $res = curl_exec($ch);
            curl_close($ch);
            return json_decode($res, true);
        } catch (Exception $e) {
            return array('resultCode'=> '5001', 'message' => $e->getMessage());
        }
    }
}

/**
 *       获取签名
 *       创建md5摘要,规则是:按参数名称a-z排序,遇到空值的参数不参加签名。
 *       @params         array               $data               参与签名的数组
 *       @params         string              $key                商户密钥
 *       @return         string              $sign               返回生成的sign
 */
if (!function_exists('getSign')) {
    function getSign($data, $key)
    {
        $query = '';
        ksort($data);
        foreach($data as $k => $v) {
            if("" != $v && "sign" != $k) {
                $query .= $k . "=" . $v . "&";
            }
        }
        $query .= 'key='.$key;
        $sign = strtoupper(MD5($query));
        return $sign;
    }
}

/**
 * 验证是否国银签名
 * @params         array               $data               参与签名的数组
 * @params         string              $gymchtKey          商户密钥
 * @params         string              $sign               签名
 * @return         bool                                    true:是 false:否
 * */
if (!function_exists('isGySign')) {
    function isGySign($data,$gymchtKey,$sign)
    {
        $gySign = getSign($data,$gymchtKey);
        return $sign==$gySign;
    }
}

/**
 * 生成32位随机字符串
 * @params         int               str              生成位数
 * */
if (!function_exists('getRandomStr')) {
    function getRandomStr($param = 32){
        $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for($i = 0; $i < $param; $i++)
        {
            $key .= $str{mt_rand(0,32)};    //生成php随机数
        }
        return $key;
    }
}