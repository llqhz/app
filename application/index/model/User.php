<?php

namespace app\index\model;

class User extends BaseModel
{


    public static function getByOpenId($openid='')
    {
        return self::where('openid','eq','openid')->find();
    }

}
