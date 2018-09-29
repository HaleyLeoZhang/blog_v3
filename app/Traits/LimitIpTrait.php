<?php
namespace App\Traits;

use ApiException;
use Consts;
use App\Helpers\Location;
use Illuminate\Support\Facades\Redis;
use Log;

/**
 * 基础服务 - 公共静态信息存储
 */

trait LimitIpTrait
{
    static $action_type     = 'limit:ip'; // 操作类型
    static $limit_pre_cycle = 150; // 单位周期次数限制
    static $time_expire     = 60; // 计算时长，单位秒
    static $init_redos_val  = -1; // 若没有，则初始化对应值

    /**
     * IP请求频率限制
     * - IP访问频率限制一般分为两层，
     * - 云天河此次是在 OSI 参考模型中的应用层，运用缓存层对临时数据进行记录
     * - 然后分别进行隔离，目前主要放在 API 层
     * @return void
     */
    public static function limit_ip()
    {
        $ip     = Location::get_ip();
        $info   = [];
        $info[] = self::$action_type;
        $info[] = $ip;
        $key    = implode(':', $info);

        $times = Redis::get($key) ?? self::$init_redos_val;

        if ($times > 0 && $times > self::$limit_pre_cycle) {
            throw new ApiException(null, Consts::AT_API_REQUEST_LIMIT);
        } else {
            Redis::incr($key);
            // 如果该IP之前不存在
            if ($times < 0) {
                $expire_at = time() + self::$time_expire;
                Redis::expireAt($key, $expire_at);
            }
            // $log = compact('ip', 'times');
            // \Log::debug('LimitIpTrait', $log);

        }

    }

}
