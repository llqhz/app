<?php

namespace app\index\model;

class User extends BaseModel
{


    public static function getByOpenId($openid='')
    {
        return self::where('openid','eq','openid')->find();
    }

    # 关联键是主键,则是hasOne  主键可以在副表有多个属性,所以是hasOne
    public function address()
    {
        return $this->hasOne('UserAddress','user_id','id');
    }

}
