<?php
namespace app\index\controller;

use app\index\model\AutoUid;
use think\Request;

class Index
{
    public function index($id='0',$name='xiao')
    {
        return 'hello '.$id.'name :'.$name;
    }


    public function hello(Request $request)
    {
        $id = $request->param('id');
        var_dump($id);
    }

    public function testUid()
    {
        $id = AutoUid::makeNo('Order');
        dump($id);
    }
}
