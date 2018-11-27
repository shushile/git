<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/11
 * Time: 19:36
 */
namespace app\admin\controller;
use think\facade\Request;
use think\Controller;

class Category extends Controller{
    public function index(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();

        $this->assign('cate',$cate);
        return view('category');
    }

    public function catesadd(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();

        if(Request::isPOST()){
            $data=Request::param(true);

            if(empty($data['c_name'])){
                $this->error('你的分类名称不能为空，将自动跳转。','Category/add');
            }else{
                $suc=db('category')->insert($data);

                if($suc){
                    $this->success("添加分类成功,将自动跳转!",'Category/category');
                }
            }
        }

        $this->assign('list',$cate);
        return view();
    }

    public function cateedit(){
        //无限级分类
        $category=controller('CategoryClass','controller');
        $cate=$category->getcatelist();

        if(Request::isGET()){
            $name=Request::param('name');
            $this->assign('name',$name);
        }

        if(Request::isPOST()){
            $c_name_old=Request::param('c_name_old');
            $c_name=Request::param('c_name');
            if(empty($c_name)){
                $this->error('请填写新的分类名称！','Category/category');exit;
            }else{
                $suc=db('category')->where("c_name='$c_name_old'")->update(['c_name'=>$c_name,]);
            }

            if($suc){
                $this->success('修改分类名称成功！','Category/category');
            }else{
                $this->error('修改分类名称失败！','Category/edit');
            }
        }

        $this->assign('list',$cate);
        return view();
    }

    public function catedelete(){
        if(Request::isGet()){
            $c_name=Request::param('name');

            $suc=db('category')->where("c_name='$c_name'")->delete();
            if($suc)
            {
                $this->success('删除分类成功!','Category/category');
            }
            else
            {
                $this->error('删除分类失败!','Category/category');
            }
        }else{
            return false;
        }
    }
}