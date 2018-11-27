<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/11/10
 * Time: 17:26
 */
namespace app\index\controller;

class ListArticle{
    public function index(){
        //view('指定名字的html文件)
        return view('list');
    }
}