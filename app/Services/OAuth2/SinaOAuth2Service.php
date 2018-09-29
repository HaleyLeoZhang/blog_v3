<?php
namespace App\Services\OAuth2;

use App\Services\OAuth2\Sina\ApiService;

// ----------------------------------------------------------------------
// OAuth2 - 新浪微博
// ----------------------------------------------------------------------
// 接口文档  http://open.weibo.com/wiki/授权机制说明
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class SinaOAuth2Service implements BaseOAuth2Service
{
    public $auth_object;

    public function __construct()
    {
        $config = config('oauth.sina');
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
        $params       = $this->auth_object->get_uid($access_token);
        extract($params); // uid
        // - 得到用户所有数据
        $arr = $this->auth_object->user_info($access_token, $uid);
        // - 过滤需要的参数 oauth_key、name、pic
        $user_info              = [];
        $user_info['oauth_key'] = $uid;
        $user_info['name']      = $arr['screen_name'];
        $user_info['pic']       = $arr['avatar_large'];
        return $user_info;
    }

}
