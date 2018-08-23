<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/16
 * Time: 15:54
 */

namespace app\index\model\traits;


trait ImgUrl
{
    public function getImgUrl($value,$data)
    {
        if ( $data['from'] == 1 ) {
            return config('img.img_prefix') . $value;
        } else {
            return $value;
        }
    }
}