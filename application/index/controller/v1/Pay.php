<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 18:28
 * @Last Modified: 2018-08-27 18:28
 * @version v1.0.0
 */

namespace app\index\controller\v1;


use app\exception\ProcessException;
use app\index\controller\BaseController;
use app\index\validate\IdMustBePositiveInt;
use app\index\model\Order as OrderModel;
use app\index\service\Pay as PayService;


class Pay extends BaseController
{
    # 前置方法
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only'=>['getPreOrder']],
    ];




    # 下单接口生成预订单
    public function getPreOrder($id='')
    {
        (new IdMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        $res = $pay->pay();
        

    }

    # 微信异步通知接口
    public function receiveNotify()
    {
        
    }
}