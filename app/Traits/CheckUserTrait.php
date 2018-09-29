<?php

namespace App\Traits;

use App\Models\AdminAuth\Admin;
use App\Models\User;
use App\Services\Auth\InfoAuthService;
use CommonService;
use LogService;

trait CheckUserTrait
{
    /**
     * 验证 普通用户是否登录 && 是否是绑定过用户的管理员
     * @return bool
     * - true->有普通用户信息，false->没有用户信息
     */
    public static function has_user_info()
    {
        // - @CASE 1: 管理员与普通用户绑定过关系
        $login_type = CommonService::LOGIN_TYPE_END_SYSTEM;
        // 授权码，放在 cookie、header、get 的字段中
        InfoAuthService::set_token($login_type);
        $admin_id = InfoAuthService::token_check();
        if ($admin_id) {
            $admin_obj            = Admin::find($admin_id);
            CommonService::$admin = $admin_obj;
            CommonService::$user  = User::find($admin_obj->user_id);
        }
        // - @CASE 2: 用户已经登录
        if (is_null(CommonService::$user)) {
            $login_type = CommonService::LOGIN_TYPE_FRONT_SYSTEM;
            // 授权码，放在 cookie、header、get 的字段中
            InfoAuthService::set_token(CommonService::LOGIN_TYPE_FRONT_SYSTEM);
            $user_id = InfoAuthService::token_check();
            if ($user_id) {
                // 记录 - 用户模型
                CommonService::$user = User::find($user_id);
            }
        }
        if (CommonService::$user) {
            // 写入 - 用户本次信息
            $log = [
                'token'     => CommonService::$user->remember_token,
                'admin_id'  => $admin_id,
                'user_id'   => CommonService::$user->id,
                'user_name' => CommonService::$user->name,
            ];
            \LogService::info('UserTokenInfo.', $log);
            return true;
        } else {
            return false;
        }
    }
}
