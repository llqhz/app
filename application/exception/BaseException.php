<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 13:28
 */

namespace app\exception;


use think\Exception;


/**
 * 统一处理自定义异常 和 参数验证异常
 * Class BaseException
 * @package app\exception
 */
class BaseException extends Exception
{
    // HTTP状态码
    protected $code = 400;

    // 自定义的错误码
    protected $errorCode = 10000;

    // 错误具体信息
    protected $msg = '参数错误';


    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->code;
    }


    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }


    // 自定义异常类  可以不参照父类实现构造方法
    public function __construct($param=[])
    {
        if ( !is_array($param) ) {
            return ;   // 参数必须是数组
        }

        if ( array_key_exists('code',$param) ) {
            $this->code = $param['code'];
        }

        if ( array_key_exists('msg',$param) ) {
            $this->msg = $param['msg'];
        }

        if ( array_key_exists('errorCode',$param) ) {
            $this->errorCode = $param['errorCode'];
        }
    }
}