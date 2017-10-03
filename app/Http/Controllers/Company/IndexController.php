<?php
/**
 * 网站首页
 * Created by PhpStorm.
 * User: yutonghe
 * Date: 2017/9/30
 * Time: 11:00
 */

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页
    public function index(){
        return view("Company.index");
    }

}
