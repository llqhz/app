<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-30 16:35
 * @Last Modified: 2018-08-30 16:35
 * @version v1.0.0
 */

namespace app\index\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['id', 'delete_time', 'update_time', 'product_id'];
}