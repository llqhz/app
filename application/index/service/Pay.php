<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 18:52
 * @Last Modified: 2018-08-27 18:52
 * @version v1.0.0
 */

namespace app\index\service;


use app\exception\ProcessException;

class Pay
{

    protected $orderId = '',
    protected $orderNo = '',

    public function __construct($order_id='')
    {
        if ( empty($order_id) ) {
            throw new ProcessException([ 'msg'=>'订单号不允许为空']);
        }
        
    }
    
    
    public function pay ( $id = '' ) {
        
    }

}