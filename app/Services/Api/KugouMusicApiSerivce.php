<?php
namespace App\Services\Api;

// ----------------------------------------------------------------------
// 酷狗音乐接口
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

use App\Helpers\CurlRequest;

// 需要引入 云天河写的对应类

class KugouMusicApiSerivce
{
    /**
     * @param String : API_SEARCH    搜索歌曲信息
     * @param String : API_PALY_URL  查询播放地址
     * @param Int    : TIMER         设置超时时间，单位，秒
     */
    const API_SEARCH   = 'https://songsearch.kugou.com/song_search_v2';
    const API_PALY_URL = 'https://wwwapi.kugou.com/yy/index.php';
    const TIMER        = 15;

    const PARAM_MID = '809186d60c77b4385b5b5246d5f4ec5c03536b1c'; // 必要请求参数

    // 必要 - 模拟头部信息
    public static $common_header = [
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Encoding:gzip, deflate, sdch',
        'Accept-Language:zh-CN,zh;q=0.8',
        'Cache-Control:no-cache',
        'Connection:keep-alive',
        'Host:songsearch.kugou.com',
        'Pragma:no-cache',
        'Upgrade-Insecure-Requests:1',
        'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 SE 2.X MetaSr 1.0',
    ];

    /**
     * 搜索对应歌手的关键词，并返回播放地址
     * @param string $keyword 音乐名称的关键词
     * @param string $singer 歌手名的关键词
     * @return string
     */
    public static function run($keyword, $singer)
    {
        $list      = self::get_music_list($keyword);
        $file_hash = self::get_singer_song($list, $singer);
        $play_url  = self::get_paly_url_by_hash($file_hash);
        return $play_url;
    }

    /**
     * 获取歌曲列表
     * @param string $keyword 关键词
     * @return array
     */
    public static function get_music_list($keyword)
    {
        CurlRequest::set_timeout_second(self::TIMER);

        $params                     = [];
        $params['callback']         = 'hlzblog'; // jsonp 名称
        $params['keyword']          = $keyword;
        $params['page']             = 1; // 页码
        $params['pagesize']         = 100; // 分页尺寸，前100条找不到就算了，哈哈
        $params['userid']           = -1;
        $params['clientver']        = ''; // 不知道这是啥
        $params['platform']         = 'WebFilter'; // 请求的平台信息
        $params['tag']              = 'em';
        $params['filter']           = 2;
        $params['iscorrection']     = 1;
        $params['privilege_filter'] = 0;
        $params['_']                = time() * 1000; // 时间戳，单位毫秒（其实因为这应该是jsonp通信的，所以是用的js的获取时间戳的结果）

        $request_url = self::API_SEARCH . '?' . http_build_query($params);

        $content = CurlRequest::run($request_url, null, self::$common_header);
        // - 解析 jsonp
        $res = self::parse_jsonp($content);
        // - 获取数据列表
        $list = $res->data->lists ?? [];
        return $list;
    }

    /**
     * 依据搜索出来的音乐列表，查询对应歌曲文件的hash值
     * @param array $list 歌曲列表
     * @param string $singer 歌手名关键词
     * @return array
     */
    public static function get_singer_song($list, $singer)
    {
        $file_hash = '';
        foreach ($list as $item) {
            $file_name = $item->FileName ?? '';
            if (preg_match('/' . $singer . '/', $file_name, $matches)) {
                $file_hash = $item->FileHash ?? '';
                break;
            }
        }
        if ('' == $file_hash) {
            throw new \Exception("未找到相关歌手");
        }
        return $file_hash;
    }

    /**
     * 依据文件 hash 搜索酷狗的音乐播放地址
     * @return string
     */
    public static function get_paly_url_by_hash($file_hash)
    {
        CurlRequest::set_timeout_second(self::TIMER);

        $params         = [];
        $params['r']    = 'play/getdata';
        $params['hash'] = $file_hash;
        $params['mid']  = self::PARAM_MID; // 这个值目前我不知道它的有效期是多长

        $request_url = self::API_PALY_URL . '?' . http_build_query($params);

        $content = CurlRequest::run($request_url);
        $res     = json_decode($content);
        $bg_url  = $res->data->play_url ?? '';
        \LogService::debug(__CLASS__.'-----', compact('bg_url', 'params','res'));
        return $bg_url;
    }

    /**
     * 解析 jsonp
     * @param $jsonp 其返回jsonp名称为callback
     * @return 对象
     */
    protected static function parse_jsonp($jsonp)
    {
        $reg = '/\((.*?)\)$/i';
        if (preg_match($reg, $jsonp, $matches)) {
            $json = $matches[1];
            return json_decode($json);
        } else {
            throw new \Exception("获取 jsonp 失败");
        }
    }

}
