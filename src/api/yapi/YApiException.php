<?php
namespace ApiGenerator\api\yapi;


use Exception;

class YApiException extends Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message, 400);
    }
}
