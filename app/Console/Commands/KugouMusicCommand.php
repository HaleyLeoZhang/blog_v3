<?php

namespace App\Console\Commands;

use App\Repositories\Common\Logic\CacheLogic;
use Illuminate\Console\Command;
use LogService;

class KugouMusicCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kugou_music';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        酷狗音乐CDN地址缓存
    ';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        LogService::info(__CLASS__ . '.start');
        $this->set_memorabilia_bg();
        LogService::info(__CLASS__ . '.end');
    }

    /**
     * 获取 大事记的音乐文件地址
     */
    public function set_memorabilia_bg()
    {
        CacheLogic::ini_memorabilia_cache();
    }

}
