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
    protected $description = '重新生成站内所需 RSA 密钥对，并重新生成前端密钥';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        LogService::info(__CLASS__ . '.start');
        $this->build_new_rsa_keys();
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

    /**
     * 生成密钥对文件
     * @return void
     */
    public function build_new_rsa_keys()
    {
        $config = [
            "private_key_bits" => \CommonService::RAS_KEY_LEN, // 字节数    512 1024  2048   4096 等
            "private_key_type" => OPENSSL_KEYTYPE_RSA, // 加密类型
        ];
        // 公钥、私钥 --- 生成
        $ssl_res = openssl_pkey_new($config);
        openssl_pkey_export($ssl_res, $rsa_pri);
        $rsa_pub = openssl_pkey_get_details($ssl_res);
        // 公钥、私钥 --- 存储
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.密钥对.已生成.正在写入');
        $this->write_key_into_file(\CommonService::RSA_FILE_PUBLIC, $rsa_pub['key']);
        $this->write_key_into_file(\CommonService::RSA_FILE_PRIVATE, $rsa_pri);
        LogService::info(__CLASS__ . '@' . __FUNCTION__ . '.密钥对.写入成功');
    }

    /**
     * 写入数据到 storage目录 对应文件路径
     * @param string $storage_path storage目录下的对应文件路径
     * @param string $key_string 密钥对给字内容
     * @return void
     */
    protected function write_key_into_file($storage_path, $key_string)
    {
        $storage_path = storage_path($storage_path);

        $fp = fopen($storage_path, 'w+');
        fwrite($fp, $key_string);
        fclose($fp);
    }

}
