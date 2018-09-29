<?php
namespace App\Services\Verify;

// ----------------------------------------------------------------------
// 分布式验证验证码的用户，唯一识别支持
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Services\Verify\SlideVerifyService;
use Illuminate\Support\Facades\Redis;

class SupportVerfiyService
{
    // - 配置项
    const PASSPORT_PIREFIX = 'verfiy:';

    protected $id; // 用户唯一识别ID
    protected $expire_at; // 过期时间 = 当前时间 + 过期时间

    protected static $instance = null;

    /**
     * 设置验证码数据
     */
    public static function get_instance()
    {
        if (!self::$instance) {
            $instance  = new self();
            $headers   = getallheaders();
            $passsport = $headers['Passport'] ?? '';
            if ('' == $passsport) {
                // $response = [
                //     "Err" => "500",
                //     "out" => "滑动验证码 passsport 不能为空",
                // ];
                // echo json_encode($response);
                // exit();
            }
            $instance->id = self::PASSPORT_PIREFIX . crc32($passsport);

            // ---------------------------------- 此部分，可以自定义 ----------------------------------

            $instance->expire_at = time() + SlideVerifyService::$timer; // 单位秒，一般设置为 30 秒，表示当前验证码，用于验证的超时时间

            self::$instance = $instance;
        };
        return self::$instance;
    }

    /**
     * 获取 对应键值的内容
     * @param string key 获取具体参数
     * @return string | array（参数$key不存在的时候）
     */
    public function get_data($key = null)
    {
        $token_val = Redis::get($this->id);

        if (!$token_val) {
            if ($key) {
                $result = '';
            } else {
                $result = [];
            }
        } else {
            $info = unserialize($token_val);

            if ($key) {
                $result = $info[$key] ?? '';
                if( is_array($result) ){
                    $result = json_encode($result);
                }
            } else {
                $result = $info ?? [];
            }
        }


        return $result;
    }

    /**
     * 合并内容到 token
     * @param Array data 一维数组数据
     * @return Void
     */
    public function set_data($data)
    {
        $before = $this->get_data();
        if ($before == []) {
            $before = [];
        }
        $arr = array_merge($before, $data);
        Redis::set($this->id, serialize($arr));
        Redis::expireAt($this->id, $this->expire_at);
    }

}
