<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Repositories\Wechat\WechatRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use LogService;

class WechatController extends BaseController
{
    // 微信签名，签名才用。平时请不要调用它了
    public function check_signature(Request $request)
    {
        $token = env('wechat_token');
        // 微信服务器，发来三个字符串，用于生成签名
        $signature = $request->input('signature', ''); // 微信服务器 用同样算法 生成的签名
        $timestamp = $request->input('timestamp', '');
        $nonce     = $request->input('nonce', '');
        // 微信服务器，发来的第四个字符串，用于告诉微信服务器，你验证成功
        $echostr = $request->input('echostr', ''); // 反正必须输出这个字符串
        // - 签名算法 => 这一块，是用来让自己知道，微信发来的请求是不是你当前正在调试的公众号的请求
        // --- 比如：你现在有 A、B两个公众号，你正在调试A，但是你地址填的B，微信公众号就以为B就是你了，所以就出错了。
        $tmp_arr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmp_arr, SORT_STRING);
        $tmp_str = implode($tmp_arr);
        $tmp_str = sha1($tmp_str); // 这个是就是你生成的签名
        // 对比 签名是否相同
        if ($tmp_str == $signature) {
            return $echostr;
        } else {
            \LogService::debug('微信入口测试失败');
            return '测试失败';
        }
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++
    //  正式开发，使用的部分
    //+++++++++++++++++++++++++++++++++++++++++++++++++++

    protected $FromUserName; // 发送方帐号
    protected $ToUserName; // 开发者微信号
    protected $CreateTime; // 消息创建时间
    protected $MsgType; // 消息类型
    protected $Event; // 事件的具体名称 ，选填
    protected $EventKey; // 事件类型
    protected $Content; // 消息内容 ，选填

    /**
     * 统一微信请求入口
     */
    public function entrance()
    {
        // ~~~~~~~~~~~~~~~~~~~~~~~微信请求我们服务器时，的必要操作~~~~~~~~~~~~~~~~~~~~~~~
        //get post data, May be due to the different environments
        $wecaht_request_xml = file_get_contents('php://input'); // 允许读取 POST 的原始数据
        //extract post data
        if (!empty($wecaht_request_xml)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
            the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $xml_string = simplexml_load_string($wecaht_request_xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $xml_object = json_decode(json_encode($xml_string));
            LogService::debug('Received Wechat Data ', [$xml_object]);

            $this->FromUserName = $xml_object->FromUserName;
            $this->ToUserName   = $xml_object->ToUserName; // 公众号
            $this->CreateTime   = $xml_object->CreateTime; // 发送过来的消息
            $this->MsgType      = $xml_object->MsgType; // 消息类型
            $this->Content      = $xml_object->Content ?? '-';
            if (isset($xml_object->Event)) {
                $this->Event = $xml_object->Event;
                if (isset($xml_object->EventKey)) {
                    $this->EventKey = $xml_object->EventKey;
                }
            }
            $this->handle_requset();
        }
    }

    /**
     * 微信事件处理
     * @return XML
     */
    private function handle_requset()
    {
        $result = array(); // 用于接收处理后的数据的
        switch ($this->MsgType) {
            // 接收普通消息
            case 'text': // 文本消息
                $result = WechatRepository::text(trim($this->Content));
                break;
            case 'image': // 图片消息
                break;
            case 'voice': // 语音消息
                break;
            case 'video': // 视频消息
                break;
            case 'shortvideo': // 小视频消息
                break;
            case 'location': // 地理位置消息
                break;
            case 'link': // 链接消息
                break;
            // 接收事件推送
            case 'event': // 接收事件推送
                if ($this->Event == 'CLICK') {
                    // 关于我们
                    if ($this->EventKey == 'About_button') {
                        $result = WechatRepository::text('About_button');
                    }
                }
                break;
            default: // 默认回复
                $result = WechatRepository::text('');
                break;
        }
        return $this->handle_response($result['event'], $result['arr']);
    }

    /**
     * 选择回复用户的事件
     * @param String event 回复的事件类型
     * @param Array  vars 回复的数组信息
     * @return XML 用于传输微信服务器的的 XML 数据
     */
    private function handle_response($event, $vars)
    {
        $vars['ToUserName']   = $this->FromUserName;
        $vars['FromUserName'] = $this->ToUserName;
        $vars['CreateTime']   = $this->CreateTime;
        // 回复事件
        switch ($event) {
            case 'text': 
                $xml = view('module/wechat/tpl_reply_text', $vars);
                break;
            case 'news':
                $xml = view('module/wechat/tpl_pic_content', $vars);
                break;
            default:
                $xml = '';
        }
        LogService::debug('Response Wechat Data --- xml  --- '. $xml );
        LogService::debug('Response Wechat Data --- vars --- ', [ $vars ]);
        echo $xml;
        exit();
    }
}
