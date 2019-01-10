<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

// ----------------------------------------------------------------------
// 分布式排他锁
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class DistributedLock
{
    const LOCK_PREFIX = 'lock:';
    const LOCK_VALUE = 1; // 锁住后，存储的固定值，应尽可能的小
    const TTL = 20; // 秒数，20秒

    /**
     * 依据微秒来生成不同字符串
     * @param  string unique_key 唯一锁名
     * @return bool
     * - true -> 未锁住
     */
    public static function run($unique_key)
    {
        // 防止多处调用，重复增加数据
        $red_lock = Redis::connection();
        $redis_key = self::LOCK_PREFIX. $unique_key;
        $log = [
            'lock_key' => $redis_key,
            'ttl'      => self::TTL,
        ];
        if( $red_lock->setnx($redis_key, self::LOCK_VALUE) ){
            $red_lock->expire($redis_key, self::TTL);
            // \Log::debug('锁住-NO ', $log);
            return true;
        }else{
            // \Log::debug('锁住-YES ', $log);
            return false;
        }
    }

}
