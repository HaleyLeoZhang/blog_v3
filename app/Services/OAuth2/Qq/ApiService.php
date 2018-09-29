<?php
namespace App\Services\OAuth2\Qq;

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
        $params['client_id']     = $this->app_id;
        $params['client_secret'] = $this->app_key;
        $params['grant_type']    = 'authorization_code';
        $params['code']          = $this->code;
        $params['redirect_uri']  = $this->callback;

        $url = 'https://graph.qq.com/oauth2.0/token?' . http_build_query($params);

        $content = CurlRequest::run($url);

        parse_str($content, $arr);
        if (!isset($arr['access_token'])) {
            \LogService::info('登陆失败.info: access_token 不存在', $arr);
            throw new \ApiException("登陆失败");
        }
        return $arr['access_token'];
    }

    /**
     * 获取 client_id 和 openid
     * @param $access_token access_token验证码
     * @return array
     * - 返回格式 ["client_id" => "...", "openid" => ""]
     */
    public function get_client_id($access_token)
    {
        $params                 = [];
        $params['access_token'] = $access_token;

        $url = 'https://graph.qq.com/oauth2.0/me?' . http_build_query($params);

        $content = CurlRequest::run($url);
        $arr     = $this->parse_jsonp($content);

        if (!isset($arr['client_id'])) {
            \LogService::info('登陆失败.info: client_id 不存在', $arr);
            throw new \ApiException("登陆失败");
        }
        return $arr;
    }

    /**
     * 获取用户信息
     * @param string $client_id
     * @param string $access_token
     * @param string $openid
     * @return array 用户的信息数组
     */
    public function user_info($access_token, $client_id, $openid)
    {
        $params                       = [];
        $params['oauth_consumer_key'] = $client_id;
        $params['access_token']       = $access_token;
        $params['openid']             = $openid;
        $params['format']             = 'json';

        $url     = 'https://graph.qq.com/user/get_user_info?' . http_build_query($params);
        $content = CurlRequest::run($url);
        // - 示例 $content 字符串
        // {
        //     "ret": 0,
        //     "msg": "",
        //     "is_lost": 0,
        //     "nickname": "沐临风",
        //     "gender": "男",
        //     "province": "北京",
        //     "city": "朝阳",
        //     "year": "1996",
        //     "constellation": "",
        //     "figureurl": "http://qzapp.qlogo.cn/qzapp/101309589/51B58D13A4392ED7ADF6F683A8FAA2ED/30",
        //     "figureurl_1": "http://qzapp.qlogo.cn/qzapp/101309589/51B58D13A4392ED7ADF6F683A8FAA2ED/50",
        //     "figureurl_2": "http://qzapp.qlogo.cn/qzapp/101309589/51B58D13A4392ED7ADF6F683A8FAA2ED/100",
        //     "figureurl_qq_1": "http://thirdqq.qlogo.cn/qqapp/101309589/51B58D13A4392ED7ADF6F683A8FAA2ED/40",
        //     "figureurl_qq_2": "http://thirdqq.qlogo.cn/qqapp/101309589/51B58D13A4392ED7ADF6F683A8FAA2ED/100",
        //     "is_yellow_vip": "0",
        //     "vip": "0",
        //     "yellow_vip_level": "0",
        //     "level": "0",
        //     "is_yellow_year_vip": "0"
        // }
        $arr = json_decode($content, true);
        return $arr;

    }

    /**
     * 解析 jsonp
     * @param $jsonp 其返回jsonp名称为callback
     * @return 数组
     */
    protected function parse_jsonp($jsonp)
    {
        if (preg_match('/callback\((.*?)\)/i', $jsonp, $matches)) {
            $json = $matches[1];
            return json_decode($json, true);
        } else {
            throw new \ApiException("获取 jsonp 失败");
        }
    }

    /**
     * 获取登录地址
     * @return string
     */
    public function get_third_login_url()
    {
        // CSRF 防护，暂不考虑，默认先带上，但是回调的时候不校验
        $this->state = md5(uniqid(rand(), true));

        $params                  = [];
        $params['which']         = 'Login';
        $params['display']       = 'pc';
        $params['response_type'] = 'code';
        $params['client_id']     = $this->app_id;
        $params['redirect_uri']  = $this->callback;
        $params['state']         = $this->state;
        $params['scope']         = 'get_user_info';

        $url = 'https://graph.qq.com/oauth2.0/show?' . http_build_query($params);
        return $url;
    }

}
