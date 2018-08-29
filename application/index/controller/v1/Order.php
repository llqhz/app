<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 14:05
 * @Last Modified: 2018-08-24 14:05
 * @version v1.0.0
 */

namespace app\index\controller\v1;


use app\exception\ProcessException;
use app\index\controller\BaseController;
use app\index\validate\IdMustBePositiveInt;
use app\index\validate\OrderPlace;
use app\index\service\Token as TokenService;
use app\index\service\Order as OrderService;
use app\index\validate\PagingParameter;
use app\index\model\Order as OrderModel;

class Order extends BaseController
{

    protected $beforeActionList = [
        'checkExclusiveScope' => [ 'only'=>['placeOrder'] ],
        'checkPrimaryScope' => [ 'only'=> ['getSummaryByUser','getDetail'] ],
    ];

    # 获取用户订单列表
    public function getSummaryByUser($page=1, $size=15)
    {
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pages = OrderModel::getSummaryByUser($uid,$page,$size);
        if ( $pages->isEmpty() ) {
            return json([
                'data' => [],
                'current_page' => $pages->currentPage(),
            ]);
        } else {
            //return json(get_class_methods($pages));
            $data = $pages->getCollection()->hidden(['snap_items','snap_address','prepay_id'])->toArray();
            return json([
                'data' => $data,
                'current_page' => $pages->currentPage(),
            ]);
        }
    }

    # 获取订单详情
    public function getDetail($id='')
    {
        (new IdMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if ( !$orderDetail ) {
            throw new ProcessException('OrderMiss');
        }
        return json($orderDetail->hidden(['prepary_id']));
    }



    //用户选择商品后，向api提交所选择的商品信息
    //api接收到信息后，需要检查订单相关商品的库存量
    //有库存，把订单数据存入数据库 = 下单成功，返回客户端消息，通知用户可以支付了
    //调用支付接口，进行支付
    //还需要再次进行库存量检测
    //服务器调用微信的支付接口进行支付
    //小程序根据服务器返回的结果拉起微信支付
    //微信会返回一个支付的结果（异步）
    //成功：也需要进行库存量检测
    //成功：扣除库存量
    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input("post.products/a");

        $uid = TokenService::getCurrentUid();
        $order = new OrderService();
        $status = $order->place($uid,$products);
        return $status;
    }
}