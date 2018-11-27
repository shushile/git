<?php
namespace my;
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/10/15
 * Time: 17:40
 */
class test{
    public function say(){
        echo "hello bro";
    }
}

$test = new \test\say();
$test->say();