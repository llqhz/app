<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 13:32
 */

namespace app\exception\banner;


use app\exception\BaseException;

class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求banner不存在';
    public $errorCode = 40000;
}