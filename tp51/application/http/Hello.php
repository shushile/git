<?php
/**
 * Created by PhpStorm.
 * User: 新
 * Date: 2018/10/25
 * Time: 16:03
 */
namespace app\http\middleware;

class Hello{
    public function handle($request,\Closure $next){
        $request->hello = 'ThinkPHP';

        return $next($request);
    }
}