<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/20
 * Time: 16:11
 */
namespace application\Admin\Controller;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    public function __construct()
    {
        $controller = request()->controller();
        if ($controller != 'Login') {
            $userInfo = Session::get('userInfo','admin');
            if (!$userInfo) {
                $this->error('无权访问,请先登录','admin/login/login');
            }else if($userInfo['con_time']<time()) {
                $this->error('登录超时,请重新登录！','admin/login/lockLogin');
            } else {
                $userInfo['con_time'] = time()+3600;
                Session::set('userInfo', $userInfo,'admin');
            }

        }
    }


}
