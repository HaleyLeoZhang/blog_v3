<?php
namespace App\Bussiness\Wechat;

// use App\Bussiness\Chat\Logic\PublicChatLogic; // - TODO
// use App\Bussiness\Chat\Logic\PrivateChatLogic; // - TODO
use App\Bussiness\Wechat\Logic\ReceiveChatLogic;

// ----------------------------------------------------------------------
// 微信订阅号 - 聊天 - 群聊、私聊
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class WechatBussiness
{

    /**
     * -
     */
    public static function text($text)
    {
        return ReceiveChatLogic::text($text);
    }

}
