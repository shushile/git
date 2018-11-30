<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/27
 * Time: 17:39
 */
namespace app\admin\controller;
//use think\Controller;
use think\facade\Request;
use think\facade\Session;

class Login extends Base{
    public function login(){
        if(Request::isPOST()){
            Request::filter(['strip_tags','htmlspecialchars','trim']);
            $name = Request::param('mg_name');
            $pwd  = md5(Request::param('mg_pwd'));

            $where = [
                'mg_name' => $name,
                'mg_pwd' => $pwd,
            ];
            $result = db('manager')->where($where)->find();

            if($result){
                $userInfo=[
                    'manname' => $result['mg_name'],
                    'con_time' => time()+3600,//现在登录的时间
                ];
                db('manager')->where($where)->update(['last_login'=>time()]);
                Session::set('userInfo',$userInfo);

                $this->redirect('Index/index');
            }else{
                $this->error('登录失败，请检查账号密码是否正确。', '/index.php/admin/Login/login');
            }
        }
        return view();
    }

    //超时登录
    public function lockLogin(){
        $userInfo = Session::get('userInfo');
        if (!$userInfo) {
            $this->error('非法操作!','admin/Login/login');
        }
        if ($userInfo['con_time']>time()) {
            $this->error('用户已在线,非法操作!','admin/Index/index');
        }
        $this->assign('userInfo', Session::get('userInfo'));
        return view('lockLogin');

    }

    public function logout(){
        if(Session::get('userInfo')){
            Session::delete('userInfo');
            if(!Session::get('userInfo')){
                $this->success('退出成功！','admin/Login/login');
            }
        }else{
            $this->error('无权访问');
        }
    }
}