<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-28 17:14
 * @Last Modified: 2018-08-28 17:14
 * @version v1.0.0
 */

namespace app\index\controller\v1;


use app\index\controller\BaseController;
use think\Controller;

class Order2 extends BaseController
{

    protected $beforeActionList = [
        'helloDedd' => [ 'only'=> ['indexDedd'] ],
    ];

    public function indexDedd()
    {
        echo ' index ';
    }


    public function helloDedd()
    {
        echo ' hello ';
    }


}