<?php


namespace App\Http\Middleware;

use Closure;
use App\Models\M3Result;

class VerifyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $m3Result=new M3Result();
        //这里是书写Login中间件的代码
        //放行
        if (! session("tologin")){
            return redirect("/login")->with("error",'请先登录！');
        }
        return $next($request);
    }
}