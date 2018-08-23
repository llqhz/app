<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 10:04
 */

namespace app\index\validate;



class IdMustBePositiveInt extends BaseValidate
{

    protected $rule = [
        'id' => 'require|isPositiveInteger',
        //'num' => 'in:1,2,3',
    ];

    protected $message = [
        'id.isPositiveInteger' => 'id必须是正整数',
    ];



}