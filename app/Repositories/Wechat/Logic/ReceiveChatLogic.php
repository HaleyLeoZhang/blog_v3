<?php
namespace App\Repositories\Wechat\Logic;

use App\Repositories\Index\Logic\IndexLogic;

// 微信回复相关

class ReceiveChatLogic
{
    /**
     * 接收用户发来的文本消息
     * @param string $text 用户发来的文本消息
     * @return Array
     */
    public static function text($text)
    {
        $arr = []; // 初始化数据
        switch ($text) {
            // case 'template':
            //     // 返回类型
            //     $event = 'news';
            //     // 第一条，最多5条
            //     $info                = [];
            //     $info['Title']       = '云天河博客活动';
            //     $info['Description'] = '留言随机送配对女友';
            //     $info['PicUrl']      = '图文的图片链接';
            //     $info['Url']         = '点击图文信息，跳转到的对应url链接';
            //     $arr['news'][]       = $info;
            //     break;
            case '1':
                $event       = 'news';
                $arr['news'] = self::lastest_five_article();
                break;
            case '2':
                $event       = 'news';
                $arr['news'] = self::hot_article();
                break;
            default:
                // 返回类型
                $event          = 'text';
                $info           = [];
                $info[]         = "您好，欢迎关注云天河Blog！";
                $info[]         = "输入1,查看火热文章";
                $info[]         = "输入2,查看最新文章";
                $info[]         = "输入3,进入云天河官网";
                $str            = implode("\n", $info);
                $arr['Content'] = $str;
                break;
        }
        return [
            'event' => $event,
            'arr'   => $arr,
        ];
    }

    /**
     * 获取最新5篇文章
     * @return array
     */
    public static function lastest_five_article()
    {
        $params = [];
        // - 首页文章列表
        $article_list = IndexLogic::dispatcher($params);
        $articles     = $article_list['info'];
        unset($article_list);
        $arr = [];
        for ($i = 0, $len = count($articles); $i < 5 && ($i < $len); $i++) {
            $one = $articles[$i];
            // 第一条
            $info          = [];
            $info['Title'] = $one->title;
            if (mb_strlen($one->descript) > 7) {
                $info['Description'] = mb_substr($one->descript, 0, 7) . '...';
            } else {
                $info['Description'] = mb_substr($one->descript, 0, 7);
            }
            $info['PicUrl'] = $one->cover_url;
            $info['Url']    = config('app.hostname') . '/mobile/#/article/' . $one->id;
            $arr[]          = $info;
        }
        return $arr;
    }

    /**
     * 5篇火热文章
     */
    public static function hot_article()
    {
        $hot_articles = IndexLogic::hot_articles();
        $arr          = [];
        for ($i = 0, $len = count($articles); $i < 5 && ($i < $len); $i++) {
            $one = $articles[$i];
            // 第一条
            $info          = [];
            $info['Title'] = $one->title;
            if (mb_strlen($one->descript) > 7) {
                $info['Description'] = mb_substr($one->descript, 0, 7) . '...';
            } else {
                $info['Description'] = mb_substr($one->descript, 0, 7);
            }
            $info['PicUrl'] = $one->cover_url;
            $info['Url']    = config('app.hostname') . '/mobile/#/article/' . $one->id;
            $arr[]          = $info;
        }
        return $arr;
    }

}
