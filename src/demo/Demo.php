<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/13
 * Time: 10:30
 */

namespace ApiGenerator\demo;

/**
 * 这是一段超级长的类注释
 * 我还故意分了h
 *好几行啊
 * Class Demo
 * @package ApiGenerator\demo
 */
class Demo
{
    /**
     * 这是一段超级长的类注释
     * 我还故意分了h
     *好几行啊
     * sadfsdfwe
     * @param string $a  desc有
     * @param string $a1  desc有sdfsdfsdfsdfsdfsdfwefwdf1
     * @return void
     */
    public static function test($a = "Sfsd")
    {
        echo "this is demo test";

    }

    /**
     * @param int $b
     * @return string
     */
    private function test2($b = 234){
        return json_encode(["code"=>1,"msg"=>"this is message"]);
    }

}