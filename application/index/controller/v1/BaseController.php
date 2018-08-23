<?php
/**
 * Created by PhpStorm.
 * User: llqhz
 * Date: 18-8-23
 * Time: 下午7:11
 */

namespace app\index\controller\v1;


use think\Controller;
use app\index\service\Token as TokenService;

class BaseController extends Controller
{
    # 权限验证 用户访问
    public function needPrimaryScope()
    {
        return TokenService::needScope(['User','Super']);
    }

    # 只有用户访问
    public function needExclusiveScope()
    {
        return TokenService::needScope(['User']);
    }




}