<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/16
 * Time: 10:21
 */

namespace ApiGenerator\api;


use ApiGenerator\api\yapi\YApi;
use ApiGenerator\Client;

class YapiClient
{
    protected  $opt = [];
    protected $docArr = [];
    protected  $yapi = null;
    public function __construct($set = [])
    {
        if($set && is_array($set)){
          $this->opt = $set;
        }
        $docCli = new Client();
        $docCli->set($this->opt);
        $this->docArr = $docCli->create();
        $this->yapi = new YApi();

    }

    //
    public function save(){
        $client = $this->getClient();
    }

    public function test(){
        $groupId = 292;

        $method = 'GET';

        $path = sprintf("/test/%s", mt_rand(0, 9999));

        $payload = [
            "status" => "done",
            "method" => $method,
            "title" => sprintf("测试接口%s", mt_rand(0, 9999)),
            "path" => $path,
            "req_params" => [
                [
                    "name" => "id", //参数名称
                    "example" => "xxx", //示例
                    "desc" => "id2"
                ]
            ],
            "req_query" => [
                [
                    "required" => "1",
                    "name" => "1111",
                    "example" => "",
                    "desc" => ""
                ],
                [
                    "required" => "0",
                    "name" => "222",
                    "example" => "",
                    "desc" => ""
                ]
            ],
            "req_headers" => [
                [
                    "required"=>"1",
                    "name"=>"Content-Type",
                    "value"=>"application\/x-www-form-urlencoded",
                    "example" => "",
                    "desc" => "ff1"
                ]
            ],
            "req_body_form"=> [
                [
                    "required" => "1",
                    "name" => "f1",
                    "type" => "text",
                    "example" => "",
                    "desc" => "ff1"
                ],
                [
                    "required" => "1",
                    "name" => "f2",
                    "type" => "text",
                    "example" => "",
                    "desc" => "ff2"
                ],
            ],
            "res_body_type" => "raw",
            "res_body"=> json_encode(['err_code' => 0]),
        ];
        $return = [];

        $yapi = new YApi();
        $res = $yapi->updateOrCreateApi($groupId,$payload);

        var_dump(23);
        var_dump($res);
    }





}