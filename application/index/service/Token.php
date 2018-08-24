<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-20 14:40
 * @Last Modified: 2018-08-20 14:40
 * @version v1.0.0
 */

namespace app\index\service;


class Token
{
    public static function generateToken()
    {
        $token = getRandStr(16);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('app.token_salt');
        return md5($token.$timestamp.$salt);
    }
}