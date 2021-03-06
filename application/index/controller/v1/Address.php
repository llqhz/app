<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 10:12
 * @Last Modified: 2018-08-24 10:12
 * @version v1.0.0
 */

namespace app\index\controller\v1;


use app\exception\ProcessException;
use app\exception\SuccessMessage;
use app\index\controller\BaseController;
use app\index\model\User as UserModel;
use app\index\model\UserAddress as UserAddressMode;
use app\index\service\Token as TokenService;
use app\index\validate\AddressNew;


class Address extends BaseController
{

    protected $beforeActionList = [
        "checkPrimaryScope" => ["only" => "createOrUpdateAddress,getUserAddress"]
    ];


    /**
     * 获取用户收货地址
     * @url GET /index/v1/address/user
     */
    public function getUserAddress()
    {
        $uid = TokenService::getCurrentTokenVar('uid');
        $userAddress = UserAddressMode::where('user_id','eq',$uid)->find();
        if ( !$userAddress ) {
            throw new ProcessException('UserAddressMiss');
        }
        return json($userAddress);
    }

    /**
     * 更新用户地址
     * @url POST /index/v1/address/user
     */
    public function createOrUpdateAddress()
    {
        // 根据token获取uid
        // 不存在 -> 异常   存在->
        // 根据数据库是否存在判断新增还是删除
        $validate = new AddressNew();
        $validate->goCheck();

        $uid = TokenService::getCurrentUid();
        $user = UserModel::with('address')->find($uid);
        if ( !$user ) {
            throw new ProcessException('UserMiss');
        }

        # 准备数据
        $data = $validate->getDataByRules(input('post.'));

        $userAddress = $user->address;
        if ( !$userAddress ) {
            # 关联新增  基于关联模型本身的新增
            $user->address()->save($data);
        } else {
            # 关联更新  基于当前模型的属性的更新,保存与当前模型的状态
            $user->address->save($data);
        }

        return json(new SuccessMessage('更新成功'));
    }



    
    
}