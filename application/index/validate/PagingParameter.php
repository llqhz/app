<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-28 16:04
 * @Last Modified: 2018-08-28 16:04
 * @version v1.0.0
 */

namespace app\index\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger|max:30',
    ];

    protected $alias = [
        'page' => '页码数',
        'size' => '每页大小'
    ];


}