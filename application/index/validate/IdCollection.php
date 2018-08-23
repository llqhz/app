<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/17
 * Time: 9:54
 */

namespace app\index\validate;


class IdCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIds',
    ];

    protected $message = [
        'ids.checkIds' => 'ids需要以逗号分隔的正整数',
    ];

    protected function checkIds($value){
        $value = explode(',',$value);
        if ( empty($value) ) {
            return false;
        }
        foreach ( $value as $id ) {
            if ( !$this->isPositiveInteger($id,'','','id') ) {
                return 'id不全是正整数';
            }
        }
        return true;
    }


}