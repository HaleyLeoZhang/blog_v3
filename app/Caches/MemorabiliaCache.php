<?php

namespace App\Caches;

/**
 * 大事记
 */
class MemorabiliaCache extends BaseCache
{

    /**
     * 缓存键值前缀
     */
    public static $cache_prefix = 'memorabilia_bg';

    /**
     * 缓存时间，单位，秒
     */
    public static $cache_ttl = 60 * 6;

    /**
     * 缓存值类型
     */
    public static $cache_type = parent::CACHE_TYPE_STRING;
}
