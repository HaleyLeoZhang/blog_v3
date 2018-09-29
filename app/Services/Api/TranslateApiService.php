<?php
namespace App\Services\Api;

// ----------------------------------------------------------------------
// 百度翻译接口
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;

class TranslateApiService
{

    /**
     * @param String API_BAIDU 百度翻译接口 - TODO 此接口已经变化过多次，有空再维护
     * @param String API_GOOGLE 谷歌翻译接口 - TODO
     * @param String TIMER 最大请求时长  单位：秒
     */
    const API_BAIDU = "http://fanyi.baidu.com/v2transapi";
    // const API_GOOGLE = "http://translate.google.com/translate_t";
    const TIMER = 5;

    protected static $_this = null;

    protected $language_before; // 翻译前，文本语种 默认:自动检测
    protected $language_after; // 翻译后，文本语种 默认:自动检测
    protected $content; // 将被翻译的文本内容
    protected $api_type; // 翻译接口类型

    public static function get_instance()
    {
        if (!self::$_this) {
            self::$_this = new self();

            self::$_this->language_before = 'auto';
            self::$_this->language_after  = 'auto';
            self::$_this->content         = '';
            self::$_this->api_type        = self::API_BAIDU;
            CurlRequest::set_timeout_second(self::TIMER);
        }
        return self::$_this;
    }

    /**
     * 设置翻译前的文本语种
     * @param string $language_before 翻译前，文本语种 默认:自动检测
     * @return self
     */
    public function set_language_before($language_before)
    {
        $this->language_before = $language_before;
        return $this;
    }

    /**
     * 设置翻译后的文本语种
     * @param string $language_after 翻译后，文本语种 默认:自动检测
     * @return self
     */
    public function set_language_after($language_after)
    {
        $this->language_after = $language_after;
        return $this;
    }

    /**
     * 设置待翻译的内容
     * @param string $content 待翻译的内容
     * @return self
     */
    public function set_content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * 翻译内容
     * @return String
     */
    public function translate()
    {
        if ('' == $this->content) {
            throw new \ApiException("请先设置翻译内容");
        }
        switch ($this->api_type) {
            case self::API_BAIDU:
                $result = $this->api_baidu();
                break;
            case self::API_GOOGLE:
                // $result = $this->api_google();
                break;
            default:
                $result = '';
                break;
        }
        $result = $this->api_baidu();
        return $result;
    }

    /**
     * 百度翻译接口
     * @return String
     */
    protected function api_baidu()
    {
        // // 供选择的语种
        // $arr = [
        //     'auto' => '自动检测',
        //     'ara'  => '阿拉伯语',
        //     'de'   => '德语',
        //     'ru'   => '俄语',
        //     'fra'  => '法语',
        //     'kor'  => '韩语',
        //     'nl'   => '荷兰语',
        //     'pt'   => '葡萄牙语',
        //     'jp'   => '日语',
        //     'th'   => '泰语',
        //     'wyw'  => '文言文',
        //     'spa'  => '西班牙语',
        //     'el'   => '希腊语',
        //     'it'   => '意大利语',
        //     'en'   => '英语',
        //     'yue'  => '粤语',
        //     'zh'   => '中文',
        // ];

        $data = [
            'from'  => $this->language_before,
            'to'    => $this->language_after,
            'query' => $this->content,
            'transtype' => 'translang',
            'simple_means_flag' => 3,
            'sign' => '962195.675234',
            'transtype' => 'translang',
            'token' => '1f802b5b1c25122b5bd3325b099630a3',
        ];
        $header = [
            'Referer:http://fanyi.baidu.com/translate?aldtype=16047&query=asd%0D%0A%0D%0A&keyfrom=baidu&smartresult=dict&lang=auto2zh',
            'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.221 Safari/537.36 SE 2.X MetaSr 1.0',
            'Origin:http://fanyi.baidu.com',
        ];
        $response  = CurlRequest::run(self::API_BAIDU, $data, $header);
        $back_info = json_decode($response);
        \LogService::info($response);
        if (isset($back_info->error)) {
            throw new \ApiException("翻译失败");
        }
        $result = $back_info['trans_result']['data']['0']['dst'] ?? '翻译失败';
        return $result;
    }
}
