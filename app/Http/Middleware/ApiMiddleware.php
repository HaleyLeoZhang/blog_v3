<?php
namespace App\Http\Middleware;

// ----------------------------------------------------------------------
// API统一访问控制
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Services\Auth\CheckAuthService;
use App\Traits\LimitIpTrait;
use Closure;

class ApiMiddleware
{
    use LimitIpTrait; // 访问频率限制

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        self::limit_ip();
        return $next($request);
    }

}
