<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/20
 * Time: 16:11
 */
namespace app\Admin\Controller;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();//调用父类的构造函数:
        $controller = request()->controller();

        if ($controller != 'Login') {
            $userInfo = Session::get('userInfo');
            if (!$userInfo) {
                $this->error('无权访问,请先登录','admin/Login/login');
            }else if($userInfo['con_time']<time()) {
                $this->redirect('admin/Login/lockLogin');
            } else {
                $userInfo['con_time'] = time()+3600;
                Session::set('userInfo', $userInfo);
            }

        }
    }


}
