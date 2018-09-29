<?php
namespace App\Repositories\Wechat\Logic;

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
        $arr = array(); // 初始化数据
        switch ($text) {
            case '活动':
                // 返回类型
                $event = 'news';
                // 第一条
                $info                = array();
                $info['Title']       = '云天河博客活动';
                $info['Description'] = '留言随机送配对女友';
                $info['PicUrl']      = '图文的图片链接';
                $info['Url']         = '点击图文信息，跳转到的对应url链接';
                $arr['news'][]       = $info;
                // // 第 n 条 [最多5条]
                // $info['Title'] = '同上';
                // $info['Description'] = '同上';
                // $info['PicUrl'] = '同上';
                // $info['Url'] = '同上';
                // $arr['news'][] = $info;
                break;
            default:
                // 返回类型
                $event = 'text';
                $str   = "您好，欢迎关注云天河Blog！\n\n'";
                $str .= "输入1,查看进行中的活动";
                $arr['Content'] = $str;
                break;
        }
        return [
            'event' => $event,
            'arr'   => $arr,
        ];
    }

}
