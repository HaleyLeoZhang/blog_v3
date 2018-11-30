<?php
namespace tests\Repositories;

use App\Repositories\Comic\ComicRepository;
use LogService;

class ComicRepositoryTest extends \TestCase
{

    public function test_detail()
    {
        LogService::debug('一人之下.爬取工作.START');
        ComicRepository::yi_ren_zhi_xia();
        LogService::debug('一人之下.爬取工作.END');
    }

}
