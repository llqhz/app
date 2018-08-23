<?php

namespace app\index\model;

use app\index\model\traits\ImgUrl;

class Product extends BaseModel
{
    # 图片url处理
    use ImgUrl;

    # 隐藏属性
    protected $hidden = ['update_time','delete_time','pivot','create_time','category_id','from'];


    # 图片读取器
    public function getMainImgUrlAttr($value,$data)
    {
        return $this->getImgUrl($value,$data);
    }

    public function imgs()
    {
        return $this->hasMany('ProductImage','img_id','id');
    }



    # 获取最近商品
    public static function getMostRecent($count)
    {
        return self::limit($count)
            ->order('create_time desc')
            ->select();

    }

    # 通过category_id 获取商品信息
    public static function getByCategoryId($category_id){
        return self::all(function($query) use ($category_id) {
            $query->where('category_id','=',$category_id);
        });
    }

    public function getProductDetail($id)
    {
        $product = self::with(['imgs.imgUrl','propertities'])->find($id);
        $product = self::with([
                'imgs' => function($query){
                    $query->with(['imgUrl'])
                        ->order('order','asc');
                }
            ])
            ->with(['propertities'])
            ->find($id);
        
    }



}
