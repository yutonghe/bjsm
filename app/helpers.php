<?php
/**
 * 配置
 * Created by PhpStorm.
 * User: yutonghe
 * Date: 2017/9/28
 * Time: 14:00
 */

//http请求
if (!function_exists('create_request')) {
    function create_request($url, $postData = null, $IsPost = true)
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

//签名原始串
if (!function_exists('get_query_str')) {
    function get_query_str(array $data)
    {
        ksort($data);
        $i = 0;
        $str = '';
        foreach($data as $k => $v){
            if($v != ''){
                if($i > 0)$str .= '&';
                $str .= $k.'='.$v;
                $i++;
            }
        }
        return $str;
    }
}

//获取签名
if (!function_exists('get_sign')) {
    function get_sign(array $data, $key)
    {
        $query = get_query_str($data);
        $sign = strtoupper(MD5($query.'&key='.$key));
        return $sign;
    }
}