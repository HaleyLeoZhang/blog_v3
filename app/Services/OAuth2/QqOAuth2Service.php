<?php
namespace App\Services\OAuth2;

use App\Services\OAuth2\Qq\ApiService;

// ----------------------------------------------------------------------
// OAuth2 - QQ
// ----------------------------------------------------------------------
// 接口文档  http://wiki.open.qq.com/wiki/website/使用Authorization_Code获取Access_Token
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class QqOAuth2Service implements BaseOAuth2Service
{
    public $auth_object;

    public function __construct()
    {
        $config = config('oauth.qq');
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
        $params       = $this->auth_object->get_client_id($access_token);
        extract($params); // $client_id, $openid
        // - 得到用户所有数据
        $arr = $this->auth_object->user_info($access_token, $client_id, $openid);
        // - 过滤需要的参数 oauth_key、name、pic
        $user_info              = [];
        $user_info['oauth_key'] = $openid;
        $user_info['name']      = $arr['nickname'];
        $user_info['pic']       = $arr['figureurl_qq_2'];
        return $user_info;
    }

}
