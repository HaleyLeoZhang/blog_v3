<?php
namespace App\Services\OAuth2;

use App\Services\OAuth2\Wechat\ApiService;

// ----------------------------------------------------------------------
// OAuth2 - Wechat
// ----------------------------------------------------------------------
// 接口文档  https://developers.weixin.qq.com/doc/oplatform/Website_App/WeChat_Login/Wechat_Login.html
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class WechatOAuth2Service implements BaseOAuth2Service
{
    public $auth_object;

    public function __construct()
    {
        $config = config('oauth.wechat');
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
        $params = $this->auth_object->get_token();
        // - 得到用户所有数据
        $arr = $this->auth_object->user_info($params);
        // - 过滤需要的参数 oauth_key、name、pic
        $user_info              = [];
        $user_info['oauth_key'] = $arr['openid'];
        $user_info['name']      = $arr['nickname'];
        $user_info['pic']       = $arr['headimgurl'];
        return $user_info;
    }

}
