<?php
namespace App\Services\OAuth2;

use App\Services\OAuth2\Github\ApiService;

// ----------------------------------------------------------------------
// OAuth2 - Github
// ----------------------------------------------------------------------
// 接口文档  https://developer.github.com/apps/building-oauth-apps/authorizing-oauth-apps/
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class GithubOAuth2Service implements BaseOAuth2Service
{
    public $auth_object;

    public function __construct()
    {
        $config = config('oauth.github');
        extract($config);
        $this->auth_object = new ApiService($appid, $appkey, $callback);
    }

    /**
     * 获取第三方登录地址
     * @param string
     */
    public function get_third_login_url()
    {
        return $this->auth_object->get_third_login_url();
    }

    /**
     * 获取用户登录后，第三方用户信息
     * @param string
     * @return array
     */
    public function get_third_user_info()
    {
        $access_token = $this->auth_object->get_token();
        // - 得到用户所有数据
        $arr = $this->auth_object->user_info($access_token);
        // - 过滤需要的参数 oauth_key、name、pic
        $user_info              = [];
        $user_info['oauth_key'] = $arr['id'];
        $user_info['name']      = $arr['login'];
        $user_info['pic']       = $arr['avatar_url'];
        return $user_info;
    }

}
