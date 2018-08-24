<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 16:49
 */

namespace app\index\service;


use app\exception\ProcessException;
use think\Exception;
use wechat\WxApp;
use app\index\model\User as UserModel;

class UserToken extends Token
{
    public function get($code='')
    {
        $app = new WxApp();
        $data = $app->login($code);
        if ( empty($data) ) {
            # 记录日志,并自动返回给客户端服务器内部错误
            throw new Exception('通过httpcurl根据code获取openid失败');
        }
        if ( array_key_exists('errcode',$data) ) {
            $this->loginError($data);
        }

        # 处理返回结果
        // 分配token
        return $this->grantToken($data);
    }


    public function grantToken($data=[])
    {
        // 通过openid判断是否存在决定产生token(缓存+db)并返回
        # wxData , uid, scope    =>  token
        $openid = $data['openid'];
        $user = UserModel::getByOpenId($openid);
        if ( $user ) {
            $uid = $user->id;
        } else {
            $user = UserModel::create([
                'openid' => $openid,
            ]);
            $uid = $user->id;
        }
        $token = self::generateToken();
        $token = $this->cacheToken($token,$data,$uid);
        return $token;
    }


    public function cacheToken($token,$data,$uid)
    {
        $data['uid'] = $uid;
        $data['scope'] = 16;
        $expire_in = config('app.token_expire_in');

        $res = cache($token,$data,$expire_in);
        if ( !$res ) {
            throw new ProcessException([
                'code' => '401',
                'errorCode' => 'Token已过期或无效Token',
                'msg' => '服务器缓存异常'
            ]);
        }
        return $token;
    }


    public function loginError($data=[])
    {
        throw new ProcessException([
            'code' => 404,
            'msg' => $data['errmsg'],
            'errorCode' => $data['errcode'],
        ]);
    }
}