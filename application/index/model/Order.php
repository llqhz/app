<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-27 14:08
 * @Last Modified: 2018-08-27 14:08
 * @version v1.0.0
 */

namespace app\index\model;


class Order extends BaseModel
{
    protected $hidden = [
        'user_id','delete_time','update_time'
    ];

    protected $autoWriteTimestamp = true;  // 时间戳(默认)/【datetime】
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $dateFormat = 'Y-m-d H:i:s';


}