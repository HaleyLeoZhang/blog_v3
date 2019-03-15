<?php

namespace App\Caches;

// 只以 Redis 作为缓存驱动

use Exception;
use Illuminate\Support\Facades\Redis;

class BaseCache
{

    /**
     * 缓存键值前缀
     */
    private static $cache_prefix;

    /**
     * 缓存时间，单位秒
     */
    private static $cache_ttl;

    /**
     * 缓存值类型
     */
    private static $cache_type;

    const CACHE_TYPE_ARRAY   = 'array';
    const CACHE_TYPE_STRING  = 'string';
    const CACHE_TYPE_INTEGER = 'integer';

    public static $limit_types = [
        self::CACHE_TYPE_ARRAY,
        self::CACHE_TYPE_STRING,
        self::CACHE_TYPE_INTEGER,
    ];

    /**
     * 初始化缓存参数
     */
    public static function init()
    {
        self::$cache_prefix = static::$cache_prefix;
        self::$cache_ttl    = static::$cache_ttl;
        self::$cache_type   = static::$cache_type;
        if (empty(self::$cache_prefix) || empty(self::$cache_ttl) || empty(self::$cache_type)) {
            throw new Exception('CACHE_CONFIG_EXCEPTION');
        }
        if (!in_array(self::$cache_type, self::$limit_types)) {
            throw new Exception('CACHE_TYPE_EXCEPTION');
        }
    }

    /**
     * 设置缓存值
     *
     * @param mixd $key_words
     * @param mixd $data
     * @return boolean
     */
    public static function set_cache_info($key_words, $data)
    {
        self::init();
        $cache_key = self::get_cache_key($key_words);
        $cache_val = self::get_cache_value($data);
        $result    = Redis::set($cache_key, $cache_val, 'EX', self::$cache_ttl);
        return $result;
    }

    /**
     * 获取缓存值
     *
     * @param mixd $key_words
     * @return mixd
     */
    public static function get_cache_info($key_words)
    {
        self::init();
        $cache_key = self::get_cache_key($key_words);
        $result    = Redis::get($cache_key);

        return self::output_cache_value($result);
    }

    /**
     * 删除缓存值
     *
     * @param mixd $key_words
     * @return boolean
     */
    public static function del_cache_info($key_words)
    {
        self::init();
        $cache_key = self::get_cache_key($key_words);
        $result    = Redis::del($cache_key);

        return $result;
    }

    /**
     * 获取缓存KEY
     *
     * @param mixd $key_words
     * @return string
     */
    public static function get_cache_key($key_words)
    {
        if (empty($key_words) && $key_words != 0) {
            throw new Exception('CACHE_KEY_WORDS_EMPTY');
        }

        $cache_key = self::$cache_prefix;
        if (is_array($key_words)) {
            foreach ($key_words as $key_word) {
                $cache_key = $cache_key . ':' . $key_word;
            }
        } else {
            $cache_key = $cache_key . ':' . $key_words;
        }
        return $cache_key;
    }

    /**
     * 获取缓存值
     *
     * @param mixd $data
     * @return mixd
     */
    public static function get_cache_value($data)
    {
        if (self::$cache_type == self::CACHE_TYPE_ARRAY) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    /**
     * 输出缓存值
     *
     * @param mixd $data
     * @return mixd
     */
    public static function output_cache_value($data)
    {
        if (self::$cache_type == self::CACHE_TYPE_ARRAY) {
            return $data ? json_decode($data, true) : [];
        }
        if (self::$cache_type == self::CACHE_TYPE_STRING) {
            return $data ? $data : '';
        }
        if (self::$cache_type == self::CACHE_TYPE_INTEGER) {
            return $data ? $data : 0;
        }
    }
}
