<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:49
 */

namespace app\exception\product;


use app\exception\ProductException;

class ProductMissException extends ProductException
{
    public $code = 404;
    public $msg = '请求商品不存在';
    public $errorCode = 20000;
}