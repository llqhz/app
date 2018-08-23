<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 13:24
 */

namespace app\exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{

    // HTTP状态码
    public $code = 400;

    // 错误具体信息
    public $msg = '参数错误';

    // 自定义的错误码
    public $errorCode = 10000;


    /**
     * 返回给客户端的错误信息
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(Exception $e)
    {
        if ( $e instanceof  BaseException ) {
            # 如果是自定义的异常   自定义异常类的抛出处理
            $this->code = $e->getHttpCode();
            $this->msg = $e->getMsg();
            $this->errorCode = $e->getErrorCode();
        } else {
            # 判断是否需要显示调试
            if ( config('app_debug') ) {
                return parent::render($e);
            }

            $this->code = 500;
            $this->msg = '服务器内部错误';
            $this->errorCode = 90000;

            # 记录日志
            $this->recordErrorLog($e);
        }

        $request = Request::instance();
        $result = [
            'error_code' => $this->errorCode,
            'msg' => $this->msg,
            'request_url' => $request->url(),
        ];
        return json($result,$this->code);

        /*
        return parent::render($e); // TODO: Change the autogenerated stub
        */
    }


    /**
     * @param Exception $e
     */
    public function recordErrorLog ( Exception $e ) {
        // 日志初始化
        Log::init([
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            'level' => ['error'],
        ]);

        // 记录日志
        Log::record($e->getMessage(),'error');
    }


}