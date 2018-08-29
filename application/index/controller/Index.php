<?php
namespace app\index\controller;

use app\index\model\AutoUid;
use app\library\enum\ScopeEnum;
use think\Controller;
use think\Request;

class Index extends BaseController
{

    protected $beforeActionList = [
        'hello' => [ 'only'=> ['index'] ],
    ];

    public function index($id='0',$name='xiao')
    {
        echo ' index ';
    }


    public function hello()
    {
        echo ' hello ';
    }

    public function testUid()
    {
        $id = AutoUid::makeNo('Order');
        dump($id);
    }
}
