<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 9:43
 */

namespace app\index\validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule =  [
        'name' => 'require|max:10',
        'email' => 'email'
    ];
}