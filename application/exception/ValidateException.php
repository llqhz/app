<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/15
 * Time: 10:51
 */

namespace app\exception;


use Throwable;

class ValidateException extends BaseException
{
    // HTTP状态码
    protected $code = 400;

    // 错误具体信息
    protected $msg = '参数错误';

    // 自定义的错误码
    protected $errorCode = 40000;


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


    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param int $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @param string $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

}