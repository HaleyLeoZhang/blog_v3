<?php
namespace App\Bussiness\Common\Logic;

use App\Services\Api\ExpressDeliveryApiService;
use App\Services\Api\ShortUrlApiService;
use Illuminate\Support\Facades\Redis;
use Log;

class CommonLogic
{

    /**
     * 依据文件 hash 搜索酷狗的音乐播放地址
     * @return string
     */
    public static function memorabilia_bg()
    {
        // 2024-8-19 因为6年过去，网络带宽不再是问题，直接开放源文件
        $bg_url = 'http://www.hlzblog.top/Others/memorabilia/music/memorabilia_bg.mp3';
//        $bg_url = CacheLogic::get_memorabilia_cache();
//        if (!$bg_url) {
//            $bg_url = CacheLogic::ini_memorabilia_cache();
//        }
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
    public static function express_delivery($no)
    {
        $track_info = ExpressDeliveryApiService::run($no);
        return $track_info;
    }

    /**
     * @return array
     */
    public static function short_url($long_url, $channel)
    {
        $short_url = ShortUrlApiService::run($long_url, $channel);
        Log::info('channel---' . $channel . ' long_url ' . $long_url . ' short_url ' . $short_url); // 后期记录入库
        return $short_url;
    }

}
