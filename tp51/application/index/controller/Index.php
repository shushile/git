<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Request;
//use think\facade\Cache;
//use think\facade\Session;

class Index extends Controller
{
    public function index()
    {
        return view();
        //$user = db('user')->where('id','>',1)->select();
        //$this->assign('list',$user);
        // 不带任何参数 自动定位当前操作的模板文件
        //return $this->fetch();
    }
}
