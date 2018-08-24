<?php
/**
 * @Author: .筱怪  llqhz@qq.com
 * @Created time:  2018-08-24 11:01
 * @Last Modified: 2018-08-24 11:01
 * @version v1.0.0
 */

namespace app\index\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        "name" => "require|isNotEmpty",
        "mobile" => "require|isMobile",
        "province" => "require|isNotEmpty",
        "city" => "require|isNotEmpty",
        "country" => "require|isNotEmpty",
        "detail" => "require|isNotEmpty"
    ];

    protected $field = [
        'name' => '姓名',
        'mobile' => '手机号',
        'province' => '省份',
        'city' => '城市',
        'country' => '国家',
        'detail' => '详细地址',
    ];


}