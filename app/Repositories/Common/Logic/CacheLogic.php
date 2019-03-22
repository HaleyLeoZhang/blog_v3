<?php

namespace App\Repositories\Common\Logic;

use App\Models\Avatar\Machine;
use App\Services\Api\KugouMusicApiSerivce;
use App\Caches\MemorabiliaCache;

class CacheLogic
{

    /**
     * 刚好遇见你-曲肖冰
     * @param int $machine_id
     * @return string
     */
    public static function ini_memorabilia_cache()
    {
        $keyword = '刚好遇见你';
        $singer  = '曲肖冰';
        $bg_url  = KugouMusicApiSerivce::run($keyword, $singer);
        $res     = MemorabiliaCache::set_cache_info('gang_hao_yu_jian_ni', $bg_url);
        \LogService::info('刚好遇见你-曲肖冰-----', compact('bg_url', 'res'));
        return $bg_url;
    }

    /**
     * 刚好遇见你-曲肖冰
     * @param int $machine_id
     * @return string
     */
    public static function get_memorabilia_cache()
    {
        $bg_url = MemorabiliaCache::get_cache_info('gang_hao_yu_jian_ni');
        return $bg_url;
    }

}
