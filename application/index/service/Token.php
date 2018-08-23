<?php
/**
 * Created by PhpStorm.
 * User: llqhz
 * Date: 18-8-22
 * Time: 下午5:47
 */

namespace app\index\service;


use app\exception\BaseException;
use app\lib\enum\ScopeNum;
use think\Cache;
use think\Request;

class Token
{
    public static function getCurrentVars($key='')
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if ( $vars ) {
            throw new BaseException([
                'msg' => 'Token 无效'
            ]);
        }
        if ( !is_array($vars) ) {
            $vars = json_decode($vars,true);
        }
        if ( array_key_exists($key,$vars) ) {
            return $vars[$key];
        } else {
            throw new BaseException([
                'msg' => '获取Token保存的变量失败'
            ]);
        }
    }

    public static function getCurrentUid()
    {
        return self::getCurrentVars('uid');
    }

    // 需要的权限
    public static function needScope($scopes=[])
    {
        $scope = self::getCurrentVars('scope');
        if ( !$scope ) {
            throw new BaseException([
                'msg' => 'Token无效或已过期'
            ]);
        }
        foreach ($scopes as $sp) {
            if ( ScopeNum::$sp == $scope ) {
                return true;
            }
        }
        throw new BaseException([
            'msg' => '暂无权限',
        ]);
    }


}