<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 14:27
 * @Last Modified: 2018-08-24 14:27
 * @version v1.0.0
 */

namespace app\index\service;


use app\exception\ProcessException;
use app\index\model\Product;
use app\index\model\UserAddress;

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

        // 创建订单



    }

    protected static function createOrder (){

    }

    public static function makeOrderNo()
    {
        
    }


    /**
     * 生产订单快照
     * @param array $status
     * @return array
     */
    public function snapOrder($status=[])
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => '',
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusAddress'];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['snapAddress'] = json_encode($this->getUserAddress);
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
            $status['orderPrice'] += $pStatus['total_price'];
            $status['totalCount'] += $pStatus['count'];

            array_push($status['pStatusArray'],$pStatus);
        }

        return $status;
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
            ->visiable(['id','price','stock','name','main_img_url'])
            ->toArray();

        return $products;
    }




}