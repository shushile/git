<?php
namespace app\http\middleware;

class Check{
	public function handle($request, \Closure $next){
        if ('think' == $request->name) {
            $request->name = 'ThinkPHP';
        }
		return $next($request);
	}
}