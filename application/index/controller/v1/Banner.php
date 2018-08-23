<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 9:19
 */

namespace app\index\controller\v1;


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
        (new IdMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerById($id);
        if ( !$banner ) {
            throw new BannerMissException();
        }
        return json($banner);
    }


    // 验证器测试
    // 独立验证 vs 验证器验证
    public function vd( $id = '1')
    {
        // 独立验证
        $data = [
            'name' => 'vendor111111',
            'email' => 'vendor@@qq.com',
        ];

        $rules = [
            'name' => 'require|max:10',
            'email' => 'email'
        ];
        // 独立验证
        // $validate = new Validate($rules);

        // 验证器验证
        $validate = new TestValidate();

        // 检测
        $validate->batch()->check($data);
        $msg = $validate->getError();
        var_dump($msg);
    }
}