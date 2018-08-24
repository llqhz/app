<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 14:07
 * @Last Modified: 2018-08-24 14:07
 * @version v1.0.0
 */

namespace app\index\validate;


use app\exception\ProcessException;

class OrderPlace
{
    protected $rule = [
        "products" => "checkProducts"
    ];
    protected $singleRule = [
        "product_id" => "require|isPositiveInteger",
        "count" => "require|isPositiveInteger"
    ];

    protected function checkProducts($values){
        if (!is_array($values)) {
            throw new ProcessException([ "msg" => "商品参数不正确" ]);
        }
        if (empty($values)) {
            throw new ProcessException([ "msg" => "商品列表不能为空"]);
        }

        $validate = new BaseValidate($this->singleRule);
        foreach ($values as $key => $value) {
            $this->checkProduct($value,$validate);
        }
        return true;
    }


    protected function checkProduct($value,$validate){
        $res = $validate->check($value);
        if ( !$res ) {
            throw new ProcessException([ "msg" => "商品列表参数错误"]);
        } else {
            return true;
        }
    }

}