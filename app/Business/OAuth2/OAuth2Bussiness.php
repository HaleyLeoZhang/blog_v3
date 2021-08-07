<?php
namespace App\Bussiness\OAuth2;

use App\Bussiness\OAuth2\Logic\ActionOAuth2Logic;

// ----------------------------------------------------------------------
// OAuth2.0服务 - 聊天 - 群聊、私聊
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class OAuth2Bussiness
{
    /**
     * 获取跳转到第三方的地址
     * @param string $oauth_name 处理类型： qq 、 sina
     * @return string
     */
    public static function get_third_login_url($oauth_name)
    {
        $url = ActionOAuth2Logic::get_third_login_url($oauth_name);
        return $url;
    }

    /**
     * 第三方登录 回调处理
     * @param array $params 获取请求过来的所有参数
     * @param string $oauth_name 处理类型： qq 、 sina
     * @return  array
     */
    public static function callback($params, $oauth_name)
    {
        $user                 = ActionOAuth2Logic::callback($params, $oauth_name);
        $login_info           = ActionOAuth2Logic::user_login($user);
        $token_info           = ActionOAuth2Logic::handle_cookie($login_info);
        $render               = [];
        $render['token_info'] = http_build_query($token_info);
        return $render;
    }

    /**
     * 用户退出帐号
     * @return void
     */
    public static function logout()
    {
        ActionOAuth2Logic::logout();
    }

}
