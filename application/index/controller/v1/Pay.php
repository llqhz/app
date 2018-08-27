<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 18:28
 * @Last Modified: 2018-08-27 18:28
 * @version v1.0.0
 */

namespace app\index\controller\v1;


use app\index\controller\BaseController;
use app\index\validate\IdMustBePositiveInt;

class Pay extends BaseController
{
    # 前置方法
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only'=>['getPreOrder']],
    ];


    public function getPreOrder($id='')
    {
        (new IdMustBePositiveInt())->goCheck();

    }
}