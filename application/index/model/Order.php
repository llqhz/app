<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 14:08
 * @Last Modified: 2018-08-27 14:08
 * @version v1.0.0
 */

namespace app\index\model;


class Order extends BaseModel
{
    protected $hidden = [
        'user_id','delete_time','update_time'
    ];

    protected $autoWriteTimestamp = true;  // 时间戳(默认)/【datetime】
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $dateFormat = 'Y-m-d H:i:s';

    # 根据订单查找商品
    public function products()
    {
        return $this->belongsToMany('Product','OrderProduct','product_id','order_id');
    }

    # 查找购买的数量
    public function items()
    {
        return $this->hasMany('OrderProduct','order_id','id');
    }


    # 订单列表分页
    public static function getSummaryByUser($uid,$page=1,$size=15)
    {
        $pageData = self::where('user_id','=',$uid)
            ->order('create_time desc')
            ->paginate($size,true,['page'=>$page]);
        return $pageData;
    }


    # 读取器/修改器
    public function getSnapItemsAttr ( $value='' ) {
        if ( empty($value) ) {
            return '';
        } else {
            return json_decode($value,true);
        }
    }

    public function getSnapAddressAttr ( $value='' ) {
        if ( empty($value) ) {
            return '';
        } else {
            return json_decode($value,true);
        }
    }


}