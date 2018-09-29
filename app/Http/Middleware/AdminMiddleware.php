<?php

namespace App\Http\Middleware;

// ----------------------------------------------------------------------
// 鉴权 - 管理员
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Models\AdminAuth\Admin;
use App\Services\Auth\CheckAuthService;
use App\Services\Auth\InfoAuthService;
use App\Traits\AdminFooterMarkTrait;
use Closure;

class AdminMiddleware
{
    use AdminFooterMarkTrait;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $login_type = \CommonService::LOGIN_TYPE_END_SYSTEM;
        // 授权码，放在 cookie、header、get 的字段中
        InfoAuthService::set_token($login_type);
        $admin_id = InfoAuthService::token_check();
        if ($admin_id) {
            // 记录 - 用户模型
            \CommonService::$admin = Admin::find($admin_id);
            // 写入 - 用户本次信息
            \LogService::info('AdminTokenInfo.token.' . InfoAuthService::$token, InfoAuthService::token_info());
            // 权限判断，以路由名为权限规则
            $rule = request()->path();
            if (CheckAuthService::check($admin_id, $rule, \CommonService::AUTH_CHECK_SUCCESS, \CommonService::AUTH_CHECK_FAILED)) {
                // 写入 - 访问足迹
                self::foot_mark();
                return $next($request);
            } else {
                return CheckAuthService::error_response($request, $login_type);
            }
        } else {
            return CheckAuthService::error_response($request, $login_type);
        }

    }

}
