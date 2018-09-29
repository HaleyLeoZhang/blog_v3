<?php
namespace App\Repositories\Log\Logic;

use App\Models\Logs\AdminLoginLog;
use App\Traits\LogLocationTrait;

class AdminLogLogic
{
    use LogLocationTrait;

    /**
     * 登录日志 - 普通用户
     * @param int $user_id 普通用户id
     * @return void
     */
    public static function admin_login_log($admin_id)
    {
        list($ip, $location) = self::location_info();

        $data = [
            'admin_id' => $admin_id, // 用户ID
            'ip'       => $ip, // 此次登录的IP信息
            'location' => $location, // 依据IP，查询出来的地理信息
        ];

        $model = AdminLoginLog::create($data);
        if (!$model) {
            throw new \ApiException(null, \Consts::USER_ACCOUNT_LOG_WRITE_FAILED);
        }
    }

}
