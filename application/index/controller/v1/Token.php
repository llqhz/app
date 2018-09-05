<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 16:34
 */

namespace app\index\controller\v1;


use app\exception\ProcessException;
use app\index\service\UserToken;
use app\index\validate\TokenGet;
use app\index\service\Token as TokenService;

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

    # 校验Token
    public function verifyToken($token=''){
        if ( !$token ) {
            throw new ProcessException('TokenMiss');
        }
        return json(['isValid'=>TokenService::verifyToken($token)]);
    }

}