<?php
namespace tests\Helpers;

use App\Helpers\DistributedLock;
use App\Helpers\Token;
use LogService;

class LockTest extends \TestCase
{

    /**
     * 测试分布式锁
     */
    public function test_distribute_lock()
    {
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.start');
        $unique_key = Token::rand_str(10, 'general');
        $lock = DistributedLock::run($unique_key); // 测试 - 加锁
        $this->assertEquals(true, $lock);
        $unlock = DistributedLock::run($unique_key); // 测试 - 解锁
        $this->assertEquals(false, $unlock);
        // sleep(DistributedLock::TTL); // 等待解锁后重新加锁
        // DistributedLock::run($unique_key); // 测试 - 重新加锁
        LogService::debug(__CLASS__ . '@' . __FUNCTION__ . '.end');
    }

}
