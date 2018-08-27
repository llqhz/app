<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 14:27
 * @Last Modified: 2018-08-24 14:27
 * @version v1.0.0
 */

namespace app\index\service;


use app\exception\ProcessException;
use app\index\model\AutoUid;
use app\index\model\OrderProduct;
use app\index\model\Product;
use app\index\model\UserAddress;
use app\index\model\Order as OrderModel;
use think\Db;
use think\Exception;


class Order
{
    # 客户端传递的products  origin
    protected $oProducts = [];

    # 数据库查询的products
    protected $products = [];

    protected $uid;


    public function place($uid='', $oProducts=[])
    {
        // oProducts 和 products 库存量对比
        $this->oProducts =  $oProducts;
        $this->uid = $uid;
        $this->products = $this->getProductsByOrder($oProducts); // 查询数据库商品信息

        $status = $this->getOrderStatus();
        if ( $status['pass'] == false ) {
            $status['order_id'] = -1;
            return $status;
        }

        // 生产订单快照
        $orderSnap = $this->snapOrder($status);

        // 开始创建订单
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;

        // 减少商品数量
        // TODO....

        return json($order);
    }

    /**
     * 写入订单信息，订单表，订单商品表
     * @param array $snap
     * @return array
     * @throws \Exception
     */
    protected function createOrder ($snap=[]){
        Db::startTrans();
        try {
            $orderNo = AutoUid::makeNo('Order');

            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];  // 订单总金额
            $order->total_count = $snap['totalCount'];  // 订单总个数
            $order->snap_img = $snap['snapImg']; //
            $order->snap_name = $snap['snapName']; //
            $order->snap_address = $snap['snapAddress']; //
            $order->snap_items = json_encode($snap['pStatus'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $order->user_id = $this->uid;

            $order->save();

            $orderId = $order->id;
            $createTime = $order->create_time;

            foreach ($this->oProducts as $key => $p) {
                $this->oProducts[$key]['order_id'] = $orderId;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
        } catch ( Exception $e ) {
            Db::rollback();
        }
        return [
            'order_no' => $orderNo,
            'order_id' => $orderId,
            'create_time' => $createTime,
        ];
    }


    /**
     * 生成订单快照
     * @param array $status
     * @return array
     */
    public function snapOrder($status=[])
    {
        $snap = [
            'orderPrice' => 0,  // 订单总金额
            'totalCount' => 0,  // 订单总数量
            'pStatus' => [],    // 每个商品的状态
            'snapAddress' => [],// 用户地址
            'snapName' => '',   // 首个商品名
            'snapImg' => '',    // 首个商品图
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        // 取首图作为缩略图
        $snap['snapName'] = $this->products[0]['name'];
        if ( count($this->products) > 1  ) {
            $snap['snapName'] .= ' 等';
        }
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        return $snap;
    }


    /**
     * 获取用户地址
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function getUserAddress(){
        $userAddress = UserAddress::where('user_id','eq',$this->uid)->find();
        if ( !$userAddress ) {
            throw new ProcessException('UserAddressMiss');
        }
        return $userAddress->toArray();
    }


    /**
     * 检测订单商品库存
     * @return bool
     */
    protected function getOrderStatus()
    {
        $status = [
            'pass' => true,  // 是否检测成功
            'orderPrice' => 0,  // 订单总金额
            'totalCount' => 0,  // 商品总数量
            'pStatusArray' => [],  // 订单包含商品详情
        ];

        # 检测订单中的每个商品
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);
            if ( $pStatus['haveStock'] == false ) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];

            array_push($status['pStatusArray'],$pStatus);
        }

        return $status;
    }

    /**
     * 根据订单号，获取购买的商品和商品库存信息
     * @param string $orderId
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkOrderStatus($orderId='')
    {
        # 根据orderId 找出用户买了什么
        $this->oProducts = OrderProduct::where('order_id','=',$orderId)->select();
        $this->products = $this->getProductsByOrder();
        return $this->getOrderStatus();
    }


    /**
     * 检测每个商品的库存 (传入pid)
     * @param int $pid
     * @param int $oCount 商品购买数量
     * @param array $products 数据库中查出的商品
     * @throws ProcessException
     */
    protected function getProductStatus($pid=0,$oCount=0,$products=[])
    {
        $pIndex = -1;
        $pStatus = [
            'id' => null,   // 商品数量
            'haveStock' => false,  // 是否有库存
            'count' => 0,   // 购买数量
            'name' => '',   // 商品名称
            'totalPrice' => 0   // 此商品总金额
        ];

        # 找到pid对应的数据库product
        $len = count($products);
        for ( $i=0; $i<$len; $i++ ) {
            if ( $pid == $products[$i]['id'] ) {
                $pIndex = $i;
            }
        }

        if ( $pIndex == -1 ) {
            throw new ProcessException(['msg'=>'商品Id '. $pid .' 不存在']);
        }

        $product = $products[$pIndex];
        $pStatus['id'] = $product['id'];
        $pStatus['count'] = $oCount;
        $pStatus['name'] = $product['name'];
        $pStatus['totalPrice'] = $oCount * $product['price'];

        if ( $product['stock'] >= $oCount ) {
            // 有库存
            $pStatus['haveStock'] = true ;
        }
        return $pStatus;
    }


    /**
     * 查询数据库商品信息
     * @param array $oProducts
     */
    public function getProductsByOrder($oProducts=[])
    {
        // 根据订单中商品id(主键)用in查询
        $pids = [];
        foreach ($oProducts as $oProduct) {
            array_push($pids,$oProduct['product_id']);
        }

        $products = Product::all($pids)
            ->visible(['id','price','stock','name','main_img_url'])
            ->toArray();

        return $products;
    }




}