<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-30 16:20
 * @Last Modified: 2018-08-30 16:20
 * @version v1.0.0
 */

namespace app\index\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    // 定义关联关系
    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}