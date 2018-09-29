<?php
namespace App\Repositories\Common;

use App\Repositories\Common\Logic\CommonLogic;

// ----------------------------------------------------------------------
// 公共
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class CommonRepository
{
    /**
     * 背景音乐
     */
    public static function memorabilia_bg()
    {
        $url       = CommonLogic::memorabilia_bg();
        $data      = compact('url');
        return $data;
    }

}
