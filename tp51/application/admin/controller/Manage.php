<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/26
 * Time: 21:06
 */
namespace app\admin\controller;
use think\facade\Request;
use think\Controller;

class Manage extends Base{
    //管理员页面
    public function manager_list(){
        $result = db('manager')->field(['mg_id','mg_name','mg_role_id'])->select();

        $this->assign('manager',$result);
        return view();
    }

    public function manager_add(){
        if(Request::isPOST()){
            $data = [
                'mg_name' => Request::param('mg_name'),
                'mg_pwd' => md5(Request::param('mg_pwd')),
                'mg_role_id' => Request::param('mg_role_id'),
            ];
            $result = db('manager')->insert($data);
            if($result){
                $this->redirect('Manage/manager');
            }
        }
        return view();
    }

    public function manager_edit(){
        if(Request::isGET()){
            $where = [
                'mg_id' => Request::only(['mg_id']),
            ];
            $result = db('manager')->field(['mg_name','mg_id'])->where($where)->find();

            $this->assign('result',$result);
        }else{
           $where = [
               'mg_id' => Request::param('mg_id'),
           ];
           $data = [
               'mg_name' => Request::param('mg_name'),
               'mg_role_id' => Request::param('mg_role_id'),
           ];
           $result = db('manager')->where($where)->update($data);
           if($result){
               $this->redirect('Manage/manager');
           }
        }
        return view();
    }

    public function manager_delete(){
        if(Request::only(['mg_id'])){
            $where = [
                'mg_id' => Request::only(['mg_id']),
            ];
            $result = db('manager')->where($where)->delete();

            if($result){
                $this->success('删除管理员成功','Manage/manager');
            }
        }
        return view();
    }
}