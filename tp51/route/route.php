<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//Route::rule('路由表达式','路由地址','请求类型');
Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::group('admin',function(){
    Route::group('Article',function(){
        Route::rule('article','admin/Article/article');
        Route::rule('add','admin/Article/add_article');
        Route::rule('modify','admin/Article/modify','GET|POST');
        Route::rule('delete','admin/Article/delete','GET|POST');
        Route::rule('brush','admin/Article/brush');
        Route::rule('reduction','admin/Article/reduction');
    });

    Route::group('Category',function(){
        Route::rule('category','admin/Category/index');
        Route::rule('add','admin/Category/catesadd');
        Route::rule('edit','admin/Category/cateedit');
        Route::rule('delete','admin/Category/catedelete');
    });
});

return [

];
