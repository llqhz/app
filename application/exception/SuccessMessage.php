<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 11:52
 * @Last Modified: 2018-08-24 11:52
 * @version v1.0.0
 */

namespace app\exception;


class SuccessMessage
{
    // HTTP状态码
    protected $code = 201;

    // 自定义的错误码
    protected $errorCode = 0;

    // 错误具体信息
    protected $msg = '操作成功';


    public function __construct($msg='',$code=201)
    {
        $this->msg = $msg;
        $this->code = $code;
    }
}