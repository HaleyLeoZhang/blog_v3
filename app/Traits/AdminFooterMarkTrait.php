<?php

namespace App\Traits;

use App\Helpers\Location;
use App\Models\AdminAuth\AdminFooterMark;
use Log;

trait AdminFooterMarkTrait
{
    /**
     * 管理员足迹记录
     */
    public static function foot_mark()
    {
        $admin = \CommonService::$admin;

        $log['admin_id'] = $admin->id;
        $log['email']    = $admin->email;
        $log['name']     = $admin->truename;
        $log['route']    = request()->path();
        $log['method']   = request()->method();
        $log['params']   = json_encode(request()->all());
        $log['ip']       = Location::get_ip();
        
        AdminFooterMark::create($log);
    }
}
