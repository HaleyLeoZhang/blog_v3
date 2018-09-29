<?php

namespace App\Console\Commands;

use App\Services\Crypt\RsaCryptService;
use Illuminate\Console\Command;
use LogService;

class RsaFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rsa_file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成站内所需 rsa 前端文件';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        LogService::info(__CLASS__ . '.start');
        $this->rebuild();
        LogService::info(__CLASS__ . '.end');
    }

    /**
     * rebuild rsa.js
     * - 生成对应js文件
     * - JS使用：rsa_encode
     * @return void
     */
    public function rebuild()
    {
        // 读取公钥
        $public_key_arr = RsaCryptService::get_key('public', 'multi_line');
        $data           = compact('public_key_arr');
        // 渲染前端加密的js
        $render = view('key.rsa_js', $data);
        // 写入JS加载路径
        $target_js_path = public_path(\CommonService::RSA_FILE_JS_PATH);
        $put_size       = file_put_contents($target_js_path, $render);
        LogService::info(__CLASS__ . '.put_size.' . $put_size);
    }

}
