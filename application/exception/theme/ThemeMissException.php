<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 10:50
 */

namespace app\exception\theme;


use app\exception\ThemeException;

class ThemeMissException extends ThemeException
{
    public $code = 404;
    public $msg = '请求theme不存在';
    public $errorCode = 30000;
}