<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 9:19
 */

namespace app\index\controller\v2;


use app\exception\banner\BannerMissException;
use app\index\model\Banner as BannerModel;
use app\index\validate\IdMustBePositiveInt;
use app\index\validate\TestValidate;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @param int $id
     */
    public function getBanner( $id = '' )
    {
        return 'this is in version2';
    }
}