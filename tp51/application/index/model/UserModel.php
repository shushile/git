<?php
namespace app\index\model;

use think\Model;

class UserModel extends Model{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'b_user';

    // 设置当前模型的数据库连接
    protected $connection = 'db_config';

    // 模型初始化
//    protected static function init()
//    {
       //TODO:初始化内容
//    }
    public function index(){
        $user = new user([
            'username' => 'thinkphp',
            'phone' => '13670610596'
        ]);
        $user->save();
    }


}