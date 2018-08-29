<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-20 14:40
 * @Last Modified: 2018-08-20 14:40
 * @version v1.0.0
 */

namespace app\index\service;


use app\exception\ProcessException;
use app\library\enum\ScopeEnum;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken()
    {
        $token = getRandStr(16);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('app.token_salt');
        return md5($token.$timestamp.$salt);
    }


    /**
     * 获取Token对应变量
     * @param string $key
     * @return mixed
     * @throws ProcessException
     */
    public static function getCurrentTokenVar($key='')
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if ( !$vars ) {
            throw new ProcessException('TokenMiss');
        }
        if ( !is_array($vars) ) {
            $vars = json_decode($vars,true);
        }
        if ( array_key_exists($key,$vars) ) {
            return $vars[$key];
        } else {
            throw new ProcessException('TokenVarMiss');
        }
    }

    /**
     * 根据Header里面的Token获取uid
     * @return mixed
     * @throws ProcessException
     */
    public static function getCurrentUid()
    {
        return self::getCurrentTokenVar('uid');
    }


    public static function needScope($scopes=[])
    {
        $scope = self::getCurrentTokenVar('scope');

        if ( !$scope ) {
            throw new ProcessException('TokenMiss');
        } else {
            foreach ( $scopes as $key => $val ) {
                if ( ScopeEnum::get($val) == $scope ) {
                    return true;
                }
            }
        }
        throw new ProcessException('Forbidden');
    }


    public static function isValidOperate( $uid = '' )
    {
        if ( !$uid ) {
            # 代码错误抛出think异常
            throw new Exception(['msg'=>'缺少uid参数']);
        }
        $currentOperateUid = self::getCurrentUid();
        if ( !$uid == $currentOperateUid ) {
            return false;
        }
        return true;
    }






}