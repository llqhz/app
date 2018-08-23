<?php

namespace app\index\model;

class BannerItem extends BaseModel
{
    # 隐藏字段
    protected $hidden = ['update_time','delete_time','img_id'];

    // 嵌套关联
    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    } 

}
