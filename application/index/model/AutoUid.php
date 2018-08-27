<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 10:35
 * @Last Modified: 2018-08-27 10:35
 * @version v1.0.0
 */

namespace app\index\model;


use think\Exception;

class AutoUid extends BaseModel
{
    public static function read($key='')
    {
        if ( empty($key) ) {
            throw new Exception('没有传入key值');
        }
        $key = strtolower($key);
        if ( !$li = self::where('key','=',$key)->find()) {
           $li = self::create([
              'key' => $key,
              'uid' => 1
           ]);
        } else {
           $li->uid ++;
        }
        $li->save();
        return $li->uid;
    }


    public static function makeNo($key)
    {
        $prefix = preg_replace('/[a-z]/','',$key);

        $uid = self::read($key);
        $uid = $uid*7 + mt_rand(0,6);
        $uid = sprintf("%06u",$uid);

        $year = date('ymd');
        $second = substr( time(),-4);
        $rands = mt_rand(100,999);
        return $prefix . $year . $uid . $second . $rands;
    }
}