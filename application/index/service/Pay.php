<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 18:52
 * @Last Modified: 2018-08-27 18:52
 * @version v1.0.0
 */

namespace app\index\service;


use app\exception\ProcessException;
use app\index\service\Order as OrderService;
use app\index\model\Order as OrderModel;
use app\library\enum\OrderStatusEnum;
use think\Loader;

# 加载没有命名空间的类
Loader::import('wechat.lib.WxPay',EXTEND_PATH,'.Api.php');

//     extend/wechat/lib/WxPay.Api.php
import('path.to.className','baseUrl','.ext');

class Pay
{

    protected $orderId = '';
    protected $orderNo = '';

    public function __construct($order_id='')
    {
        if ( empty($order_id) ) {
            throw new ProcessException([ 'msg'=>'订单号不允许为空']);
        }
        
    }
    
    
    public function pay ( $id = '' ) {
        # 订单号是否存在
        # 订单号和用户是否匹配
        # 订单没有被支付
        # 库存量检测
        $this->checkOrderValid();

        $order = new OrderService();
        $status = $order->checkOrderStatus($this->orderId);
        if ( !$status['pass'] ) {
            return $status;
        } else {

        }
    }

    protected function makeWxPreOrder() {
        $openid = Token::getCurrentTokenVar('openid');

    }


    # 检测订单
    protected function checkOrderValid(){
        # 订单号是否存在
        $order = OrderModel::get($this->orderId);
        if ( !$order ) {
            throw new ProcessException('OrderMiss');
        }

        # 订单号和用户是否匹配
        if ( !Token::isValidOperate($order->uid) ) {
            throw new ProcessException(['msg'=>'订单与用户不匹配']);
        }

        # 订单是否被支付
        if ( $order->status != OrderStatusEnum::UNPAID ) {
            throw new ProcessException(['msg'=>'订单已经支付']);
        }

        $this->orderNo = $order->order_no;
        return true;
    }


}