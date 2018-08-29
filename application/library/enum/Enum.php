<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-29 10:00
 * @Last Modified: 2018-08-29 10:00
 * @version v1.0.0
 */

namespace app\library\enum;


class Enum
{
    // ScopeEnum::get('User');
    public static function __callStatic($fun='', $values=[])
    {
        if ( $fun == 'get' ) {
            return constant('static::'.$values[0]);
        }
    }
}