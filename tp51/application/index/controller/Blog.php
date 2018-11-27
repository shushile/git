<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/10/25
 * Time: 17:37
 */
namespace app\index\Controller;

use think\facade\Request;
class Blog{
    public function read(){
        return Request::param('id/d');
    }
    public function archive($year,$month='01'){
        Request::cache('__URL__',360);
        return Request::param('year').' '.Request::param('month');

    }
}