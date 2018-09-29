<?php
namespace App\Http\Middleware;

// ----------------------------------------------------------------------
// 鉴权 - 管理员、用户，有没普通用户信息
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Traits\CheckUserTrait;
use Closure;

class CheckUserMiddleware
{
    use CheckUserTrait;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        self::has_user_info();
        // - @CASE 3: 未做过任何登录操作
        // - 允许需有情况的正常请求
        return $next($request);

    }

}
