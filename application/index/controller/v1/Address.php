<?php
/**
 * Created by PhpStorm.
 * User: llqhz
 * Date: 18-8-22
 * Time: 下午6:01
 */

namespace app\index\controller\v1;

use app\exception\BaseException;
use app\index\service\Token as TokenService;
use app\index\model\User as UserModel;
use app\lib\enum\ScopeNum;
use think\Controller;
use think\Request;

class Address extends BaseController
{
    /*protected $beforeActionList = [
        'first',   # 所有操作的前置操作名
        # 可以用first保护和实现protected方法的访问
        'second' =>  ['except'=>'hello'],  # 除了hello外所有方法的前置操作
        'three'  =>  ['only'=>'hello,data'],  # 只有hello和data方法的前置操作
    ];*/

    protected $beforeActionList = [
        'needPrimaryScope' => [ 'only' => 'createOrUpdateAddress' ],
    ];


    public function createOrUpdateAddress()
    {
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if ( !$user ) {
            throw new BaseException([
                'msg' => '用户不存在'
            ]);
        }
        $data = Request::instance()->param();
        $userAddress = $user->address();
        # 关联模型的操作
        if ( !$userAddress ) {
            # 关联模型的新增
            $user->address()->save($data);
        } else {
            # 关联模型的更新
            $user->address->save($data);
        }
    }
}