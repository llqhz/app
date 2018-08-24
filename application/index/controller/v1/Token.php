<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 16:34
 */

namespace app\index\controller\v1;


use app\index\service\UserToken;
use app\index\validate\TokenGet;

class Token
{
    # 通过code获取自定义Token
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $userToken = new UserToken();
        $token = $userToken->get($code);
        return json(['token'=>$token]);
    }
}