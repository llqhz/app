<?php

namespace app\index\model;

use app\index\model\traits\ImgUrl;

class Image extends BaseModel
{

    use ImgUrl;

    # 隐藏字段
    protected $hidden = ['update_time','delete_time','id','from'];


    # 读取器 url
    public function getUrlAttr($value,$data)
    {
        return $this->getImgUrl($value,$data);
    }
}
