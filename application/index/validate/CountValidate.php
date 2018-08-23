<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 14:36
 */

namespace app\index\validate;


class CountValidate extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];

    protected $message = [
        'count.isPositiveInteger' => 'count必须是正整数'
    ];
}