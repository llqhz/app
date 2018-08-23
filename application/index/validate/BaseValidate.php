<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 10:21
 */

namespace app\index\validate;


use app\exception\ValidateException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        # 获取input参数
        # 校检
        # 返回错误
        $request = Request::instance();
        $param = $request->param();

        $result = $this->batch()->check($param);
        if ( !$result ) {
            # 参数校检失败
            throw new ValidateException([
                'code' => 400,
                'msg' => $this->error,
                'errorCode' => '400002'
            ]);

        } else {
            return true;
        }
    }

    protected function isPositiveInteger( $value, $rule = '', $data = '', $field = '' )
    {
        if ( is_numeric($value) && is_integer($value+0) && ($value>0) )
        {
            return true;
        } else {
            return false;
        }
    }
}