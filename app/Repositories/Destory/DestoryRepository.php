<?php
namespace App\Repositories\Destory;

use App\Repositories\Destory\Logic\DestoryLogic;

// ----------------------------------------------------------------------
// 公共
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class DestoryRepository
{
    /**
     * 中国移动短信下发
     * 页面地址 https://login.10086.cn/html/login/touch.html
     * @return bool
     */
    public static function china_mobile_login($target_mobile)
    {
        $send_status  = DestoryLogic::china_mobile_login($target_mobile);
        return $send_status;
    }


}
