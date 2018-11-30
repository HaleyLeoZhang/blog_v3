<?php
namespace App\Repositories\Comic;

use App\Repositories\Comic\Logic\YiRenZhiXiaComicLogic;
use App\Repositories\Comic\Logic\OutputComicLogic;

// ----------------------------------------------------------------------
// 漫画爬取服务
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ComicRepository
{

    /**
     * 漫画 - 一人之下，转存到第三方图床
     * @return void
     */
    public static function yi_ren_zhi_xia()
    {
        YiRenZhiXiaComicLogic::yi_ren_zhi_xia();
    }

    /**
     * 漫画 API
     * @return array
     */
    public static function pic_list($params):array
    {
        $list = OutputComicLogic::pic_list($params);
        return $list;
    }

}
