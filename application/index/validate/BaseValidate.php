<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 10:21
 */

namespace app\index\validate;


use app\exception\ProcessException;
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

    /**
     * 根据验证器的规则过滤数据
     * @param array $data
     * @return array
     * @throws ProcessException
     */
    public function getDataByRules($data=[])
    {
        if (array_key_exists("user_id",$data)|array_key_exists("uid",$data)) {
            throw new ProcessException(["msg" => "参数中禁止包含userid或uid"]);
        }

        $res = [];
        foreach ($data as $key => $value) {
            $res[$key] = $value;
        }
        return $res;
    }

    /**
     * 数据为正整数
     */
    protected function isPositiveInteger( $value, $rule = '', $data = '', $field = '' )
    {
        if ( is_numeric($value) && is_integer($value+0) && ($value>0) )
        {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 数据不为空
     */
    protected function isNotEmpty( $value, $rule = '',$data = '', $field = '' ) {
        if ( empty($value) ) {
            return $field . ' 不能为空';
        } else {
            return true;
        }
    }

    /**
     * 是否手机号
     */
    protected function isMobile( $value ){
        $rule = "^1(3|4|5|7|8)[0-9]\d{8}$^";
        $result = preg_match($rule,$value);
        if ( $result ) {
            return true;
        }else{
            return false;
        }
    }


}