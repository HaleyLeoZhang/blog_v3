<?php
namespace App\Repositories\Wechat;

// use App\Repositories\Chat\Logic\PublicChatLogic; // - TODO
// use App\Repositories\Chat\Logic\PrivateChatLogic; // - TODO
use App\Repositories\Wechat\Logic\ReceiveChatLogic;

// ----------------------------------------------------------------------
// websocket服务 - 聊天 - 群聊、私聊
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class WechatRepository
{

    /**
     * -
     */
    public static function text($text)
    {
        ReceiveChatLogic::text($text);
    }

}
