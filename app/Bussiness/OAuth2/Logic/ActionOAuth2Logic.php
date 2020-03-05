<?php
namespace App\Bussiness\OAuth2\Logic;

use App\Models\User;
use App\Bussiness\Log\LogBussiness;
use App\Services\Auth\InfoAuthService;
use App\Services\OAuth2\GithubOAuth2Service;
use App\Services\OAuth2\QqOAuth2Service;
use App\Services\OAuth2\SinaOAuth2Service;

class ActionOAuth2Logic
{

    static $name_to_oauth2_map = [
        "qq"     => User::USER_TYPE_QQ,
        "sina"   => User::USER_TYPE_SINA,
        "github" => User::USER_TYPE_GITHUB,
    ];

    static $allow_oauth2_type_list = [
        User::USER_TYPE_QQ,
        User::USER_TYPE_SINA,
        User::USER_TYPE_GITHUB,
    ];

    static $oauth2_class_map = [
        User::USER_TYPE_QQ     => QqOAuth2Service::class,
        User::USER_TYPE_SINA   => SinaOAuth2Service::class,
        User::USER_TYPE_GITHUB => GithubOAuth2Service::class,
    ];


    /**
     * 获取 Oauth 对象
     * @param string $oauth_name
     * @return App\Services\OAuth2\...
     */
    public static function get_oauth_obj($oauth_name)
    {
        if (!array_key_exists($oauth_name, self::$name_to_oauth2_map)) {
            throw new \Exception("未知的第三方类型");
        }
        $oauth_type = self::$name_to_oauth2_map[$oauth_name];
        $object = new self::$oauth2_class_map[$oauth_type];
        return $object;
    }

    /**
     * 获取跳转到第三方的地址链接
     * @return string
     */
    public static function get_third_login_url($oauth_name): string
    {
        $object = self::get_oauth_obj($oauth_name);
        $url    = $object->get_third_login_url();
        return $url;
    }

    /**
     * @return \App\Models\User
     */
    public static function callback($params, $oauth_name): User
    {
        $object    = self::get_oauth_obj($oauth_name);
        $user_type = self::$name_to_oauth2_map[$oauth_name];
        // 获取用户基本信息  oauth_key、name、pic

        $user_info = $object->get_third_user_info();
        // - crc32
        $user_info['crc32'] = crc32($user_info['oauth_key'] . $user_type);
        $user               = User::where('crc32', $user_info['crc32'])->first();
        if (is_null($user)) {
            $user_info['type'] = $user_type;
            User::create($user_info);
        } else {
            $user->update($user_info);
        }
        $user_read = User::where('crc32', $user_info['crc32'])->first();
        return $user_read;
    }

    /**
     * 用户登录逻辑
     * @param \App\Models\User $user
     * @return $array
     */
    public static function user_login($user)
    {
        // 帐号状态判断
        if ($user->status != User::STATUS_NORMAL_USER) {
            $message = User::$message_status[$user->status];
            $report  = [
                'user_id' => $user->id,
                'name'    => $user->name,
                'message' => $message,
            ];
            \LogService::info('This user is inavailable', $report);
            throw new \ApiException('您的帐号异常，请联系管理员重试');
        }
        // 删除上一次的登录信息
        InfoAuthService::set_token(\CommonService::LOGIN_TYPE_FRONT_SYSTEM);
        InfoAuthService::delete($user->remember_token);

        // 写入用户 mobile、token、user_id 到缓存信息
        $token      = InfoAuthService::get_rand_token();
        $token_info = [
            'id' => $user->id,
        ];
        $user->remember_token = $token;
        $user->save();
        InfoAuthService::set_token(\CommonService::LOGIN_TYPE_FRONT_SYSTEM, $token);
        InfoAuthService::token_info($token_info);
        // 写入登录日志
        LogBussiness::user_login_log($user->id);
        // 返回 token 给客户端
        return [
            'token' => $token,
        ];
    }

    /**
     * 获取写入cookie的信息
     * @param array $result 含有 token 信息
     * @return array
     */
    public static function handle_cookie($result)
    {
        $passport_info = \CommonService::$passport_system[\CommonService::LOGIN_TYPE_FRONT_SYSTEM];
        // - 写入身份
        $expire_at = time() + $passport_info['token_expire'];
        \LogService::debug('TOKEN_EXPIRE_AT:' . $expire_at, $result);
        $data = [
            'token_name'  => $passport_info['token_name'],
            'token_value' => $result['token'],
            'expire_at'   => $expire_at,
        ];
        return $data;
    }

    /**
     * @return void
     */
    public static function logout()
    {
        $passport_info = \CommonService::$passport_system[\CommonService::LOGIN_TYPE_FRONT_SYSTEM];
        // - 清空身份
        // --- 服务端数据清洗
        $token = $_COOKIE[$passport_info['token_name']] ?? '';
        InfoAuthService::set_token(\CommonService::LOGIN_TYPE_FRONT_SYSTEM, $token);
        InfoAuthService::delete();
    }

}
