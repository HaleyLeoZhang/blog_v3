<?php
namespace App\Services\Auth;

use App\Helpers\Token;
use Illuminate\Support\Facades\Redis;

// ----------------------------------------------------------------------
// 各种用户登录信息，存取逻辑
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class InfoAuthService
{

    public static $token         = ''; // http请求携带的token
    public static $passport_info = null; // 登录信息

    /**
     * 获取请求中的 token
     * - 依次从 header、get、cookie 中获取 token
     * @param tinyint $login_type 登录类型
     * @param tinyint $token 自定义token
     */
    public static function set_token($login_type, $token = null)
    {
        if (is_null($token)) {
            self::$passport_info = \CommonService::$passport_system[$login_type];

            $request_token = self::$passport_info['token_name'];
            // 授权码，放在 cookie、header、get 的字段中
            self::$token = request()->header($request_token, '');
            if ('' == self::$token) {
                self::$token = request()->input($request_token, '');
            }
            if ('' == self::$token) {
                self::$token = $_COOKIE[$request_token] ?? '';
            }
        } else {
            self::$token         = $token;
            self::$passport_info = \CommonService::$passport_system[$login_type];
        }

    }

    /**
     * CURD token中的数据
     * 为空时，返回token中的数据，否则更新数据到 token
     * @param Array data
     */
    public static function token_info($data = [])
    {
        if ([] == $data) {
            return self::get_data();
        } else {
            return self::set_data($data);
        }
    }

    /**
     * 检测AuthToken是否正确
     * @return int 用户id
     */
    public static function token_check()
    {
        $arr = self::get_data();
        if (count($arr)) {
            return $arr['id'] ?? 0;
        } else {
            return 0;
        }
    }

    /**
     * 删除用户当前token
     * @return void
     */
    public static function token_delete()
    {
        $arr = self::delete();
    }

    // ------------------------------------
    //      内部逻辑
    // ------------------------------------

    public static function get_token_name()
    {
        $token_name = self::$passport_info['token_prefix'] . self::$token;
        return $token_name;
    }

    /**
     * 获取 token内容
     * @return Array
     */
    public static function get_data()
    {
        $token_name = self::get_token_name();
        $token_val  = Redis::get($token_name);
        if (!$token_val) {
            return []; // 查询不到时
        }
        return unserialize($token_val);
    }

    /**
     * 合并内容到 token
     * @param Array data 数组数据
     * @return Void
     */
    public static function set_data($data)
    {
        $token_name = self::get_token_name();
        $before     = self::get_data();
        $token_life = time() + self::$passport_info['token_expire'];
        if ($before == null) {
            $before = [];
        }
        $arr          = array_merge($before, $data);
        $redis_set    = Redis::set($token_name, serialize($arr));
        $redis_expire = Redis::expireAt($token_name, $token_life);
        $token_prefix = self::$passport_info['token_prefix'];
    }

    /**
     * 删除 过期 token
     * @return Void
     */
    public static function delete()
    {
        $token_name = self::get_token_name();
        Redis::del($token_name);
    }

    /**
     * 生成新 token
     * @return string
     */
    public static function get_rand_token()
    {
        return Token::rand_token();
    }

}
