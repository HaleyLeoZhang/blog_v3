<?php
namespace App\Repositories\Common\Logic;

use App\Services\Api\ExpressDeliveryApiService;
use App\Services\Api\KugouMusicApiSerivce;
use Illuminate\Support\Facades\Redis;
use App\Caches\MemorabiliaCache;

class CommonLogic
{

    /**
     * 依据文件 hash 搜索酷狗的音乐播放地址
     * @return string
     */
    public static function memorabilia_bg()
    {
        $keyword = '刚好遇见你';
        $singer  = '曲肖冰';
        $bg_url = MemorabiliaCache::get_cache_info('gang_hao_yu_jian_ni');
        if( !$bg_url ){
            $bg_url  = KugouMusicApiSerivce::run($keyword, $singer);
        }
        return $bg_url;
    }

    /**
     * 缓存大事记背景音乐的地址
     * @return string
     */
    public static function cache_get_memorabilia_bg()
    {
        $bg_url = self::memorabilia_bg();
        Redis::set(self::CACHE_MEMORABILIA_BG, $bg_url, 'EX', self::CACHE_TTL);
    }

    /**
     * @return array
     */
    public static function express_delivery($tracking_number)
    {
        $track_info = ExpressDeliveryApiService::run($tracking_number);
        return $track_info;
    }

}
