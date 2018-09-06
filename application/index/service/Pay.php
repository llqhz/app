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
use wechat\WxApp;

# 加载没有命名空间的类
Loader::import('wechat.lib.WxPay',EXTEND_PATH,'.Api.php');

//     extend/wechat/lib/WxPay.Api.php
import('path.to.className','baseUrl','.ext');

class Pay
{

    protected $orderId = '';   // 订单id
    protected $orderNo = '';   // 订单号

    public function __construct($order_id='')
    {
        if ( empty($order_id) ) {
            throw new ProcessException([ 'msg'=>'订单号不允许为空']);
        }
        $this->orderId = $order_id;
    }
    
    // 检测订单是否有效,并返回支付参数
    public function pay ( $id = '' ) {
        # 订单号是否存在
        # 订单号和用户是否匹配
        # 订单没有被支付
        # 库存量检测
        $this->checkOrderValid();

        $order = new OrderService();
        $status = $order->checkOrderStatus($this->orderId);
        if ( !$status['pass'] ) {
            return $status;  // 库存量检测失败
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    // 生成预订单,返回支付参数
    protected function makeWxPreOrder($totalPrice=0) {
        $openid = Token::getCurrentTokenVar('openid');
        if ( !$openid ) {
            throw new ProcessException('TokenMiss');
        }

        // 生成支付参数
        $wxapp = new WxApp('app');
        /*
         * @param  array  $config => body,          商品描述
         *                           out_trade_no,  商户订单号
         *                           total_fee,     支付金额
         *                           notify_url,    回调通知地址
         *                           openid,        用户openid
         */
        $config = [
            'body' => '商品描述',
            'out_trade_no' => $this->orderNo,
            'total_fee' => $totalPrice,
            'openid' => $openid
        ];
        list($code,$res) = $wxapp->wxpay($config);
        if ( $code == 1 ) {
            return $res;
        } else {
            throw new ProcessException(['msg'=>$res]);
        }
    }


    # 检测订单
    protected function checkOrderValid(){
        # 订单号是否存在
        $order = OrderModel::get($this->orderId);
        if ( !$order ) {
            throw new ProcessException('OrderMiss');
        }

        # 订单号和用户是否匹配
        if ( !Token::isValidOperate($order->id) ) {
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