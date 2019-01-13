<?php
namespace tests\Repositories;

use App\Repositories\Comic\ComicRepository;
use LogService;
use Illuminate\Support\Facades\Redis;

class ComicRepositoryTest extends \TestCase
{

    public function test_detail()
    {
        $token_name = 'test_download';
        $token_val  = Redis::get($token_name);
        if( !$token_val ){
            // // 每30秒检测一次程序是否需要重启
            // $token_life = time() + 30;
            // Redis::set($token_name, 1);
            // $redis_expire = Redis::expireAt($token_name, $token_life);
            LogService::debug('一人之下.爬取工作.START');
            ComicRepository::yi_ren_zhi_xia();
            LogService::debug('一人之下.爬取工作.END');
        }else{
            LogService::debug('一人之下.爬取工作.已在进行中。。。');
        }

    }

}
