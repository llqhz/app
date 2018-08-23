<?php

namespace app\index\model;

class Theme extends BaseModel
{

    # 隐藏字段
    protected $hidden = ['update_time','delete_time','topic_img_id','head_img_id'];

    # 关联话题图像
    public function topicImg()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }

    # 关联头图图像
    public function headImg()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }

    # 关联主题下具体产品
    public function products()
    {
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }


    public static function getThemeWithProducts($theme_id='')
    {
        return self::with(['products','topicImg','headimg'])->find($theme_id);
    }



}
