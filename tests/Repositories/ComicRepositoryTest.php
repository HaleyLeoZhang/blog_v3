<?php
namespace tests\Repositories;

use App\Repositories\Comic\ComicRepository;
use LogService;
use Illuminate\Support\Facades\Redis;

class ComicRepositoryTest extends \TestCase
{

    // public function test_yi_ren_zhi_xia()
    // {
    //     $token_name = __FUNCTION__;
    //     $token_val  = Redis::get($token_name);
    //     if( !$token_val ){
    //         // // 每30秒检测一次程序是否需要重启
    //         // $token_life = time() + 30;
    //         // Redis::set($token_name, 1);
    //         // $redis_expire = Redis::expireAt($token_name, $token_life);
    //         LogService::debug('一人之下.爬取工作.START');
    //         ComicRepository::yirenzhixia();
    //         LogService::debug('一人之下.爬取工作.END');
    //     }else{
    //         LogService::debug('一人之下.爬取工作.已在进行中。。。');
    //     }
    // }

    // public function test_zui_qiang_nong_min_gong()
    // {
    //     $token_name = __FUNCTION__;
    //     $token_val  = Redis::get($token_name);
    //     if( !$token_val ){
    //         // // 每30秒检测一次程序是否需要重启
    //         // $token_life = time() + 30;
    //         // Redis::set($token_name, 1);
    //         // $redis_expire = Redis::expireAt($token_name, $token_life);
    //         LogService::debug('最强农民工.爬取工作.START');
    //         ComicRepository::zuijiangnongmingong();
    //         LogService::debug('最强农民工.爬取工作.END');
    //     }else{
    //         LogService::debug('最强农民工.爬取工作.已在进行中。。。');
    //     }

    // }

    public function test_jie_mo_ren()
    {
        $token_name = __FUNCTION__;
        $token_val  = Redis::get($token_name);
        if( !$token_val ){
            // // 每30秒检测一次程序是否需要重启
            // $token_life = time() + 30;
            // Redis::set($token_name, 1);
            // $redis_expire = Redis::expireAt($token_name, $token_life);
            LogService::debug('戒魔人.爬取工作.START');
            ComicRepository::jiemoren();
            LogService::debug('戒魔人.爬取工作.END');
        }else{
            LogService::debug('戒魔人.爬取工作.已在进行中。。。');
        }

    }
}
