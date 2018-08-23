<?php

namespace app\index\model;

class Category extends BaseModel
{
    # 隐藏字段
    protected $hidden = ['update_time','delete_time'];

    # 关联图片
    public function img()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }

}
