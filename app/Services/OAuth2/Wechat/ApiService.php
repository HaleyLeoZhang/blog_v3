<?php
namespace App\Services\OAuth2\Wechat;

use App\Helpers\CurlRequest;

class ApiService
{
    public $app_id;
    public $app_key;
    public $callback;
    public $code;
    public $state; // CSRF 防护，本项目暂不需要

    public function __construct($app_id, $app_key, $callback)
    {
        // 接收从qq登陆页返回来的值
        $this->code  = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
        $this->state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
        // 将参数赋值给成员属性
        $this->app_id   = $app_id;
        $this->app_key  = $app_key;
        $this->callback = $callback;
    }

    /**
     * 获取 access_token 值
     * @return string
     */
    public function get_token()
    {
        $params                  = [];
        $params['appid']     = $this->app_id;
        $params['secret'] = $this->app_key;
        $params['code']          = $this->code;
        $params['grant_type']  = 'authorization_code';

        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?' . http_build_query($params);


        $get['appid']      = env('wechat_appid');
        $get['secret']     = env('wechat_appkey');
        $get['code']       = $_GET['code'] ?? ''; // 由回调页面传来
        $get['grant_type'] = 'authorization_code';
        $url .= http_build_query($get);

        $content = CurlRequest::run($url);

        $arr = json_decode($content, true);

        if (!isset($arr['access_token'])) {
            \LogService::info('登陆失败.info: access_token 不存在', $arr);
            throw new \ApiException("登陆失败");
        }
        return $arr; // access_token、openid
    }

    /**
     * 获取用户信息
     * @param $access_token
     * @return array 用户的信息数组
     */
    public function user_info($params)
    {
        extract($params);
        $params                       = [];
        $params['access_token']   = $access_token;
        $params['openid']       = $openid;
        $params['lang']       = 'zh_CN ';
        $url     = 'https://api.weixin.qq.com/sns/userinfo?' . http_build_query($params);
        $content = CurlRequest::run($url);
        // - 示例 $content 字符串
        // {
        //     "subscribe": 1, 
        //     "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M", 
        //     "nickname": "Band", 
        //     "sex": 1, 
        //     "language": "zh_CN", 
        //     "city": "广州", 
        //     "province": "广东", 
        //     "country": "中国", 
        //     "headimgurl":"http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
        //     "subscribe_time": 1382694957,
        //     "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
        //     "remark": "",
        //     "groupid": 0,
        //     "tagid_list":[128,2],
        //     "subscribe_scene": "ADD_SCENE_QR_CODE",
        //     "qr_scene": 98765,
        //     "qr_scene_str": "",
        //     "unionid": "" // 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
        // }

        // ------------------------------- 字段解释 -------------------------------
        // - openid 以公众号为单位
        // --- 如，公众号A 申请了公众号支付功能，则可以其对应的 openid 来填写订单信息
        // - unionid 以公司为单位，
        // --- 如，一个企业可以有很多种微信号，如，订阅号、公众号1、公众号2..，为方便管理，我们需要一个公共身份
        // --- 企业内的业务人员都能识别这个用户

        $arr = json_decode($content, true);
        return $arr;

    }

    /**
     * 获取登录地址
     * @return string
     */
    public function get_third_login_url()
    {
        $params                  = [];
        $params['appid']         = $this->app_id;
        $params['redirect_uri']  = $this->callback;
        $params['response_type'] = 'code';
        $params['scope']         = 'snsapi_userinfo';

        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?' . http_build_query($params);
        $url .= '#wechat_redirect'; // 文档里说，这里必须加上这个hash值

        return $url;
    }

}
