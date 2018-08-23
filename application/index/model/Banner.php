<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 11:21
 */

namespace app\index\model;


class Banner extends BaseModel
{

    # 定义数据表名
    protected $name = 'banner';

    # 隐藏字段
    protected $hidden = ['update_time','delete_time'];


    # 定义关联的外键
    public function items()
    {
        // 由id通过BannerItem的banner_id关联相关数据
        return $this->hasMany('BannerItem','banner_id','id');
    }


    public static function getBannerById($id=1)
    {
        return self::with(['items','items.img'])->find($id);
    }
}