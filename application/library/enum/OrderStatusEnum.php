<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-28 10:17
 * @Last Modified: 2018-08-28 10:17
 * @version v1.0.0
 */

namespace app\library\enum;


class OrderStatusEnum
{
    # 待支付
    const UNPAID = 1;

    # 已支付
    const PAID = 2;

    # 已发货
    const DELIVERED = 3;

    # 已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;

}