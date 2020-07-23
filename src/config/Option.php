<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/6/23
 * Time: 11:07
 */

namespace ApiGenerator\config;


class Option
{

    public static $scanArr = [
        //namespace==>dir
//        "ApiGenerator\demo"  =>"/home/wwwroot/demo.com/src/demo",
        "ApiGenerator\demo"  => __DIR__."/../demo",
    ];

    public static $css = "https://www.layuicdn.com/layui/css/layui.css";//layui 的csdn
    public static $js = "https://www.layuicdn.com/layui/layui.js";// layui的csdn



}