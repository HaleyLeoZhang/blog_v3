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
    const TTL = 10; // 默认秒数，20秒

    /**
     * 依据微秒来生成不同字符串
     * - 单机场景---通过原子操作实现
     * @param  string unique_key 唯一锁名
     * @param  int    ttl 过期时间
     * @return bool
     * - true -> 未锁住
     */
    public static function run($unique_key, $ttl = self::TTL)
    {
        // 防止多处调用，重复增加数据
        $red_lock = Redis::connection();
        $redis_key = self::LOCK_PREFIX. $unique_key;
        $log = [
            'lock_key' => $redis_key,
            'ttl'      => $ttl,
        ];
        if( $red_lock->set($redis_key, self::LOCK_VALUE, 'EX', $ttl, 'NX') ){
            \Log::debug('锁住-NO ', $log);
            return true;
        }else{
            \Log::debug('锁住-YES ', $log);
            return false;
        }
    }

    /**
     * 多机场景--- - https://redis.io/topics/distlock
     * 在算法的分布式版本中，我们假设我们有N个Redis主机。这些节点完全独立，因此我们不使用复制或任何其他隐式协调系统。我们已经描述了如何在单个实例中安全地获取和释放锁。我们理所当然地认为算法将使用此方法在单个实例中获取和释放锁。在我们的示例中，我们设置N = 5，这是一个合理的值，因此我们需要在不同的计算机或虚拟机上运行5个Redis主服务器，以确保它们以大多数独立的方式失败。
     * 
     * 为了获取锁，客户端执行以下操作：
     * 
     * - 它以毫秒为单位获取当前时间。
     * - 它尝试按顺序获取所有N个实例中的锁，在所有实例中使用相同的键名和随机值。在步骤2期间，当在每个实例中设置锁定时，客户端使用与总锁定自动释放时间相比较小的超时以获取它。例如，如果自动释放时间是10秒，则超时可以在~5-50毫秒范围内。这可以防止客户端长时间保持阻塞状态，试图与Redis节点通话失败：如果实例不可用，我们应该尝试尽快与下一个实例通话。
     * - 客户端通过从当前时间中减去在步骤1中获得的时间戳来计算获取锁定所需的时间。当且仅当客户端能够在大多数实例中获取锁定时（至少3个）并且获取锁定所经过的总时间小于锁定有效时间，认为锁定被获取。
     * - 如果获得了锁，则其有效时间被认为是初始有效时间减去经过的时间，如步骤3中计算的。
     * - 如果客户端由于某种原因（无法锁定N / 2 + 1实例或有效时间为负）未能获取锁定，它将尝试解锁所有实例（即使它认为不是能够锁定）
     */

    public static function run_mulity($unique_key, $ttl = self::TTL)
    {
        // - TODO
    }

}
