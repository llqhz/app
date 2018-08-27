<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
/*
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];*/

use think\Route;

# Route::rule('路由表达式','路由地址','请求类型','路由参数(数组)','变量规则(数组)');

# 请求类型 [get,post,put,delete,*]

# 路由参数


// Route::rule('hello','index/index/index','get|post',['https'=>false]);
/*
Route::get();
Route::post();
Route::any();
*/


# Route::get('hello/:id','index/index/index');
#　Route::get('banner/:id','index/v1.Banner/getBanner');

# 获取banner
Route::get('index/:version/banner/:id','index/:version.Banner/getBanner');

# 获取主题及主题商品
Route::get('index/:version/themes','index/:version.Theme/getSimpleList');

# 获取主题+主题商品详情
Route::get('index/:version/theme/:id','index/:version.Theme/getComplexOne');

# 获取最近商品详情
Route::get('index/:version/product/recent','index/:version.product/getRecent');

# 获取分类列表
Route::get('index/:version/category/all','index/:version.Category/getAllCategories');

# 获取分类的商品信息
Route::get('index/:version/product/by_category/:id','index/:version.Product/getAllByCategory');

# 获取用户Token
Route::get('index/:version/token/user','index/:version.Token/getToken');

# 增加收货地址
Route::post('index/:version/address','index/:version.Address/createOrUpdateAddress');

# 订单
Route::group('index/:version/order',function (){
    # 下单
    Route::get('/place','index/:version.Order/placeOrder');
});

# 支付
Route::group('index/:version/pay',function (){
    # 下单
    Route::get('/pre_order/:id','index/:version.Pay/getPreOrder');
});


# 测试方法
Route::get('test/uid','index/index/testUid');














