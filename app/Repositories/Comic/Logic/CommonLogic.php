<?php
namespace App\Repositories\Comic\Logic;

use App\Helpers\CurlRequest;
use App\Models\Logs\ComicDownloadLogs;
use App\Services\Cdn\SmCdnService;

class CommonLogic
{


    const IS_UPLOAD_TO_CLOUD = false; // 上传到图床的开关

    const SLEEP_UNIT = 1; // 每多少张，执行一次挂起操作
    const SLEEP_GAP  = 4; // 挂起进程时长，单位秒

    const PIC_API = 'https://m.tohomh.com/action/play/read'; // 漫面接口

    const COMIC_INDEX = 'https://www.tohomh.com/'; // 漫画首页的前缀

    // 初始化的数据，返回的各个索引号的意义
    const DATA_INDEX_PAGE_ID            = 0; // 这一话的页面ID
    const DATA_INDEX_CURRENT_PAGE       = 1; // 第多少话
    const DATA_INDEX_INNER_PAGE_COUNTER = 2; // 这一话的总数


    /**
     * 完成爬取、解析、下载等功能
     * @return void
     */
    public static function run($comic_id)
    {
        $params = [
            'comic_id' => $comic_id,
        ];

        $zh = ComicDownloadLogs::$comic_info[$comic_id]['zh'];

        $ini_data = CommonLogic::ini_page($params);

        $payload = [
            'comic_id_in_third' => $ini_data['comic_id_in_third'],
        ];
        \LogService::debug($zh . '.ini ', $ini_data);

        list(
            $last_page, 
            $last_inner_page
        ) = self::get_last_index($params);

        foreach ($ini_data['data'] as $one_page) {
            $post_data = [
                'comic_id_in_third' => $ini_data['comic_id_in_third'],
                'comic_id'          => $comic_id,
                'page'              => $one_page[CommonLogic::DATA_INDEX_CURRENT_PAGE],
                'inner_page'        => 0,
            ];
            $log_name = $zh . '.第' . $post_data['page'] . '话';

            if( $last_page > $post_data['page']  ){
                \LogService::debug($log_name . '.skip');
                continue;
            }


            // 寻找这话的所有图片
            for ($i = 1; $i <= $one_page[CommonLogic::DATA_INDEX_INNER_PAGE_COUNTER]; $i++) {

                if( $last_inner_page > $i  ){
                    \LogService::debug($log_name . '第'.$i.'页.skip');
                    continue;
                }


                $post_data['inner_page'] = $i;

                $content = CommonLogic::request_api($post_data);
                $res     = json_decode($content);
                $src     = $res->Code ?? false;
                if ($src) {
                    CommonLogic::download_src($src, $post_data);
                    \LogService::debug($log_name . '第'.$i.'页.success');
                } else {
                    \LogService::debug($log_name . '第'.$i.'页.failed');
                }
            }
            \LogService::warn($log_name . '.end');
        }

    }

    // ------------------------------------------------------------------------------

    protected static $index_header = [
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Encoding:gzip, deflate, sdch, br',
        'Accept-Language:zh-CN,zh;q=0.8',
        'Cache-Control:no-cache',
        'Connection:keep-alive',
        'Cookie:Hm_lvt_4be6660a7fb279361739554296e9954e=1543279998,1543565488; Hm_lpvt_4be6660a7fb279361739554296e9954e=1543567559',
        'Host:www.tohomh.com',
        'Pragma:no-cache',
        'Upgrade-Insecure-Requests:1',
        'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1',
    ];

    protected static $download_header = [
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Encoding:gzip, deflate, sdch, br',
        'Accept-Language:zh-CN,zh;q=0.8',
        'Cache-Control:no-cache',
        'Connection:keep-alive',
        'Cookie:Hm_lvt_4be6660a7fb279361739554296e9954e=1543279998,1543565488; Hm_lpvt_4be6660a7fb279361739554296e9954e=1543567559',
        'Host:m.tohomh.com',
        'Pragma:no-cache',
        'Upgrade-Insecure-Requests:1',
        'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1',
    ];

    /**
     * 初始化获取当前漫画的漫画话数与页数信息(只获取主线数据)、漫画ID
     */
    public static function ini_page($params)
    {
        extract($params); //  comic_id
        $en = ComicDownloadLogs::$comic_info[$comic_id]['en'];
        $zh = ComicDownloadLogs::$comic_info[$comic_id]['zh'];

        $data    = null;
        $url     = self::COMIC_INDEX . $en;
        $content = CurlRequest::run($url, $data, self::$index_header);

        // 解析资源ID
        $comic_id_in_third = 0;
        if (preg_match('/value="(\d+)" name="dataid"/', $content, $matches)) {
            $comic_id_in_third = $matches[1] ?? '0';
            unset($matches);
        }

        // 解析关键数据
        if (preg_match('/detail\-list\-select\-2(.*?)\<\/ul/s', $content, $matches)) {
            $wait_parse = $matches[1] ?? '';
            unset($matches);
        } else {
            $wait_parse = '';
        }
        unset($content);

        // 组装数据
        $fill_data = [];
        if (preg_match_all('/(\d+)\.html.*?llow.*?\>(.*?)(\d+)P.*?\<a/s', $wait_parse, $matches)) {
            $counter = count($matches[0]); // 总计匹配次数
            for ($i = 0; $i < $counter; $i++) {
                // $matches 的索引号 1 2 3 分别表示    对应话的页面id；对应话数（解析为整型后>0）； 对应话图片数
                // ---- 为了减少数据存到内存中的量，以下皆为索引顺序
                $tpl = [];

                $tpl[self::DATA_INDEX_PAGE_ID]            = $matches[1][$i]; // 对应话的页面id；
                $tpl[self::DATA_INDEX_CURRENT_PAGE]       = intval($matches[2][$i]) ?? 0; // 对应话数（解析为整型后>0），否则舍去
                $tpl[self::DATA_INDEX_INNER_PAGE_COUNTER] = $matches[3][$i]; // 对应话图片数
                if (0 == $tpl[1]) {
                    continue;
                }
                $fill_data[] = $tpl;
            }
            unset($matches);
        }
        unset($wait_parse);

        $back = [
            'comic_id_in_third' => $comic_id_in_third,
            'data'              => $fill_data, // 每个数组内容包含  `对应章节.html前的数字`  `分页数`
        ];

        // 获取数据
        \LogService::debug($zh . '.总计漫画主线数' . count($fill_data));
        // 返回数据

        return $back;
    }

    /**
     * 判断资源是否下载过了
     * @param array $params 查询所需的参数  comic_id、page、inner_page
     * @return bool
     */
    public static function is_exists($params): bool
    {
        extract($params); //  comic_id、page、inner_page
        $counter = ComicDownloadLogs::where('comic_id', ComicDownloadLogs::COMMIC_ID_YIRENZHIXIA)
            ->where('page', $i)
            ->where('inner_page', $current_pic)
            ->where('status', ComicDownloadLogs::STATUS_VALID)
            ->count();
        return (bool) $counter;
    }

    /**
     * 下载资源
     * @param string $src 资源地址
     * @param array $params 存储所需的参数  comic_id、page、inner_page
     * @return void
     */
    public static function download_src($src, $params)
    {
        extract($params); //  comic_id、page、inner_page

        // Action 1  拉取资源
        $pic_data = CurlRequest::run($src);
        // Action 2  存储资源
        $en   = ComicDownloadLogs::$comic_info[$comic_id]['en'];
        $path = storage_path("comic/{$en}/" . $page);
        if (!is_dir($path)) {
            mkdir($path, 0700, true); // 递归创建目录
        }
        $pic_local_path = $path . '/' . $inner_page . '.jpg';
        $fp             = fopen($pic_local_path, 'a+');
        fwrite($fp, $pic_data);
        fclose($fp);
        // Action 3  上传资源
        if (self::IS_UPLOAD_TO_CLOUD) {
            // 上传到图床 sm.ms
            $cdn_path = SmCdnService::get_instance()->upload($pic_local_path);
            // 上传频率限制，防止被封，如果真要上传，可变成队列上传
            if (0 == $inner_page % self::SLEEP_UNIT) {
                sleep(self::SLEEP_GAP);
            }
        } else {
            $cdn_path = $pic_local_path;
        }
        $data = [
            'comic_id'   => $comic_id,
            'page'       => $page,
            'inner_page' => $inner_page,
            'src'        => $cdn_path,
        ];
        ComicDownloadLogs::create($data);
    }

    /**
     * 获取动漫网的图片资源地址
     * @param array $params 查询所需的参数  comic_id_in_third、page、inner_page
     * @return string
     */
    public static function request_api($params)
    {
        extract($params); // comic_id_in_third、page、inner_page

        $data = null;

        $get = [
            'did' => $comic_id_in_third, // 在资源源站的ID
            'sid' => $page, // 对应章节.html前的数字
            'iid' => $inner_page, // 页内第几张，最大为章节话数的最大值
            'tmp' => microtime(true),
        ];

        $url     = self::PIC_API . '?' . http_build_query($get);
        $content = CurlRequest::run($url, $data, self::$download_header);

        return $content;
    }

    /**
     * 获取最后一次下载的位置
     * @param array $params 查询所需参数 comic_id
     * @return array
     */
    public static function get_last_index($params)
    {
        extract($params); //  comic_id
        $obj = ComicDownloadLogs::where('comic_id', $comic_id)
            ->orderBy('page', 'desc')
            ->orderBy('inner_page', 'desc')
            ->first();
        return [
            $obj->page ?? 1,
            $obj->inner_page ?? 1,
        ];
    }

}
