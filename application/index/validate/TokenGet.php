<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 16:35
 */

namespace app\index\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        // 当只有参数名 没传参数值时, require会通过
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code.isNotEmpty' => 'code码不能为空',
    ];


}