<?php
/**
 * Created by PhpStorm.
 * User: llqhz
 * Date: 18-8-23
 * Time: 下午10:09
 */

namespace app\index\validate;


use app\exception\BaseException;

class OrderPlace extends BaseValidate
{
    protected $product = [
        [ 'id' => 1, 'count' => 3 ],
        [ 'id' => 2, 'count' => 3 ],
        [ 'id' => 3, 'count' => 3 ],
    ];


    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected function checkProducts($values){
        if ( !is_array($values) ) {
            throw new BaseException(['msg'=>'参数异常']);
        }
        if ( empty($values) ) {
            throw new BaseException(['msg'=>'商品列表为空']);
        }

    }

    protected function checkProduct($value){

    }


}