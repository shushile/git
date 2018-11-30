<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/11
 * Time: 19:15
 */
namespace app\admin\controller;
use think\facade\Session;
use think\facade\Request;

class Index extends Base{
    public function index(){
        return view();
    }

    public function chngpwd(){
        $userInfo = Session::get('userInfo');

        if(Request::isPOST()){
            $where=['mg_name'=>Request::param('mg_name')];
            $res=db('manager')->where($where)->update(['mg_pwd'=>md5(Request::param('mg_pwd'))]);
            if($res){
                $this->success('更改密码成功','Index/index');
            }
        }
        return view();
    }
}