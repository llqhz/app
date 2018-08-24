<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-20 10:53
 * @Last Modified: 2018-08-20 10:53
 * @version v1.0.0
 */

namespace app\exception;


class ProcessException extends BaseException
{
    // HTTP状态码
    public $code = 500;

    // 错误具体信息
    public $msg = '服务器内部错误';

    // 自定义的错误码
    public $errorCode = 50000;

    protected $exceptions = [
        'BannerMiss' => [
            'code' => 404,
            'msg' => '请求banner不存在',
            'errorCode' => 40000,
        ],
        'ThemeMiss' => [
            'code' => 404,
            'msg' => '请求主题不存在',
            'errorCode' => 30000,
        ],
        'ProductMiss' => [
            'code' => 404,
            'msg' => '请求商品不存在',
            'errorCode' => 20000,
        ],
        'CategoryMiss' => [
            'code' => 404,
            'msg' => '请求分类不存在',
            'errorCode' => 50000,
        ],
        'TokenMiss' => [
            'code' => 404,
            'msg' => 'Token无效',
            'errorCode' => 50000,
        ],
        'TokenVarMiss' => [
            'code' => 404,
            'msg' => 'Token获取的变量无效',
            'errorCode' => 50000,
        ],
        'UserMiss' => [
            'code' => 404,
            'msg' => '用户不存在',
            'errorCode' => 50000,
        ],
        'Forbidden' => [
            'code' => 403,
            'msg' => '暂无权限',
            'errorCode' => 50000,
        ],
    ];


    /**
     * ProcessException constructor.
     * @param string|array $type
     */
    public function __construct($type='')
    {
        if ( is_string($type) ) {
            if ( array_key_exists($type,$this->exceptions) ) {
                parent::__construct($this->exceptions[$type]);
            }
        } elseif ( is_array($type) ) {
            parent::__construct($type);
        }
    }
}