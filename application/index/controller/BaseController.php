<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 10:11
 * @Last Modified: 2018-08-24 10:11
 * @version v1.0.0
 */

namespace app\index\controller;


use app\index\controller\traits\Mended;
use think\Controller;
use app\index\service\Token as TokenService;

class BaseController extends Controller
{
    // 调整控制器方法
    use Mended;


    /**
     * 用户和管理员都可以访问
     * @return bool
     * @throws \app\exception\ProcessException
     */
    public function checkPrimaryScope()
    {
        return TokenService::needScope(['User','Super']);
    }

    /**
     * 只有用户可以访问
     * @return bool
     * @throws \app\exception\ProcessException
     */
    public function checkExclusiveScope()
    {
        return TokenService::needScope(['User']);
    }



}