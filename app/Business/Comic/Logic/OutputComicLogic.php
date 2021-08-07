<?php
namespace App\Bussiness\Comic\Logic;

use App\Models\Logs\ComicDownloadLogs;

class OutputComicLogic
{
    const CURL_PER_SEC = 10; // 每秒爬取次数限制
    const PIC_API      = 'https://m.tohomh.com/action/play/read';
    const PIC_CDN_HOST = 'https://manhua.wzlzs.com';

    /**
     * @return array
     */
    public static function pic_list(array $params): array
    {
        extract($params); // comic_id，page
        $list = ComicDownloadLogs::selectRaw('src')
            ->where('comic_id', $comic_id)
            ->where('page', $page)
            ->where('status', ComicDownloadLogs::STATUS_VALID)
            ->orderBy('inner_page', 'asc')
            ->get();
        if (count($list)) {
            $data = $list->toArray();
        } else {
            throw new \ApiException("暂无内容");

        }
        return $data;
    }

}
