<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 11:59
 */

namespace app\index\controller\v1;


use app\exception\ProcessException;
use app\exception\product\ProductMissException;
use app\index\validate\CountValidate;
use app\index\model\Product as ProductModel;
use app\index\validate\IdMustBePositiveInt;


class Product
{

    /**
     * 获取最新创建的商品信息
     * @url /index/v1/product/getRecent?count=15
     */
    public function getRecent($count=15)
    {
        (new CountValidate())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ( $products->isEmpty() ) {
            throw new ProcessException('ProductMiss');
        }
        // 隐藏数据集对象的summary字段
        # $products = collection($products);
        $products->hidden(['summary']);

        return json($products);
    }


    public function getAllByCategory($id='')
    {
        (new IdMustBePositiveInt())->goCheck();
        $products = ProductModel::getByCategoryId($id);
        if ( $products->isEmpty() ) {
            throw new ProcessException('ProductMiss');
        }
        $products->hidden(['summary']);
        return json($products);
    }


    public function getDetail($id='')
    {
        (new IdMustBePositiveInt())->goCheck();
        $product = ProductModel::getDetail($id);
        if ( !$product ) {
            throw new ProcessException('ProductMiss');
        }
        return json($product);
    }

}