<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 15:44
 */

namespace app\exception\category;


use app\exception\CategoryException;

class CategoryMissException extends CategoryException
{
    public $code = 404;
    public $msg = '请求分类不存在';
    public $errorCode = 50000;
}