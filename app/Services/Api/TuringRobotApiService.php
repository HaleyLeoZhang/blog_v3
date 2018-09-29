<?php

namespace App\Services\Api;

// ----------------------------------------------------------------------
// 图灵机器人
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;
use Log;

class TuringRobotApiService
{
    /**
     * @param String PUBLIC_API   公共接口，返回格式：XML
     * @param String PRIVATE_API  私人接口，返回格式：Json
     * @param String TIMER        最大请求时长  单位：秒
     */
    const API_PUBLIC  = "http://www.tuling123.com/api/product_exper/chat.jhtml";
    const API_PRIVATE = "http://www.tuling123.com/openapi/api";
    const TIMER       = 5;

    /**
     * 请求接口类型
     */
    const API_TYPE_PUBLIC  = 1;
    const API_TYPE_PRIVATE = 2;

    /**
     * @param String sentence  用户输入内容
     * @param String trans_id  用户对话唯一识别码
     * @param String api_type  API类型
     * @param String private_key  私人图灵机器人的请求权限码
     */
    protected $sentence;
    protected $trans_id;
    protected $api_type;
    protected $private_key;

    static protected $_this = null;

    public static function get_instance()
    {
        if( !self::$_this ){
            self::$_this              = new self();
            self::$_this->private_key = env('TURNING_PRIVATE_KEY', '');
            CurlRequest::set_timeout_second(self::TIMER);
        }
        return self::$_this;
    }

    /**
     * 设置用户对话唯一识别码
     * @param string $token 一句话
     * @return self
     */
    public function set_trans_id($trans_id)
    {
        $this->trans_id = $trans_id;
        return $this;
    }

    /**
     * 设置用户对机器人说的话
     * @param string $sentence 一句话
     * @return self
     */
    public function set_sentence($sentence)
    {
        $this->sentence = $sentence;
        return $this;
    }

    /**
     * 选择api，进行调用
     * 返回 API 类型
     * @param  int  api_type  请求API类型
     * @return array
     */
    public function request($api_type)
    {
        switch ($api_type) {
            case self::API_TYPE_PUBLIC:
                $response = $this->api_public();
                break;
            case self::API_TYPE_PRIVATE:
                $response = $this->api_private();
                break;
            default:
                throw new \ApiException("API类型错误");
                break;
        }
        return $response;
    }

    /**
     * 公共图灵Api => 无限次使用
     * @return array
     */
    private function api_public()
    {
        $request_data           = [];
        $request_data['info']   = $this->sentence;
        $request_data['userid'] = $this->trans_id;

        $back_data = CurlRequest::run(self::API_PUBLIC, $request_data);
        Log::debug('TuringRobotApiService.' . __FUNCTION__ , $request_data);
        Log::debug('TuringRobotApiService.' . __FUNCTION__ . '.' . $back_data);

        $response = simplexml_load_string($back_data, 'SimpleXMLElement', LIBXML_NOCDATA);

        if (is_null($response)) {
            throw new \ApiException('API请求错误');
        }

        $return         = [];
        $return['type'] = $response->MsgType;

        switch ($return['type']) {
            case 'text':
                $return['data'] = $response->Content;
                return $return;
            case 'news':
                $return['data'] = [
                    'count' => $response->ArticleCount,
                    'list'  => $response->Articles, // Title、Url、PicUrl
                ];
                return $return;
            default:
                $return['data'] = '本宝宝听不懂你在说什么';
                return $return;
        }
    }

    /**
     * 私人图灵Api => 限制使用次数，作者的机器人：[名称]慧慧 [性别] 女
     * @return array
     */
    private function api_private()
    {
        // json格式请求，数据形式也得是json格式
        $request_data           = [];
        $request_data['key']    = $this->private_key;
        $request_data['info']   = strip_tags($this->sentence);
        $request_data['userid'] = $this->trans_id;
        Log::debug('TuringRobotApiService.' . __FUNCTION__ , $request_data);

        // json格式请求，数据形式也得是json格式
        $header = [
            'Content-Type: application/json',
        ];

        $back_data = CurlRequest::run(self::API_PRIVATE, json_encode($request_data), $header);
        Log::debug('TuringRobotApiService.' . __FUNCTION__ . '.' . $back_data);
        $response = json_decode($back_data);

        if (is_null($response)) {
            throw new \ApiException('API请求错误');
        }

        $return         = [];
        $return['type'] = 'text';

        switch ($response->code) {
            case '100000':
            case '40002':
                $text = $response->text;
                break;
            case '40004': // 当日已无调用次数
                $text = '今天我嗓子好累啊。。。有事我们明天聊吧';
                break;
            default:
                $text = '亲爱的，我不明白你的意思啊';
        }
        $return['data'] = $text;
        return $return;
    }

}
