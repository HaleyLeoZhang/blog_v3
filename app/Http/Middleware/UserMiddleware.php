<?php
namespace App\Http\Middleware;

// ----------------------------------------------------------------------
// 鉴权 - 用户
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Services\Auth\CheckAuthService;
use App\Traits\CheckUserTrait;
use Closure;

class UserMiddleware
{
    use CheckUserTrait;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $has_user = self::has_user_info();

        if ($has_user) {
            return $next($request);
        } else {
            return CheckAuthService::error_response($request, \CommonService::LOGIN_TYPE_FRONT_SYSTEM);
        }

    }

}
