<?php
/**
 * Created by PhpStorm.
 * User: llqhz
 * Date: 18-8-23
 * Time: 下午6:33
 */

namespace app\index\controller\v1;


use app\exception\BaseException;
use app\index\service\Token as TokenService;
use app\lib\enum\ScopeNum;


class Order extends BaseController
{
    # 用户下单 -> 检测库存 ->
    # 有库存 -> 下单成功 -> 支付
    # 支付时检测库存
    # 支付成功检测库存

    protected $beforeActionList = [
        'needExclusiveScope' => [ 'only' => 'placeOrder' ],
    ];

    /*下单*/
    public function placeOrder()
    {

    }

    /**
     * 删除订单
     */
    public function deleteOrder()
    {

    }






















}