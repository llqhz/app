<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 14:27
 * @Last Modified: 2018-08-27 14:27
 * @version v1.0.0
 */

namespace app\index\model;


class OrderProduct extends BaseModel
{
    public function product()
    {
        return $this->belongsTo('Product','product_id','id');
    }
}