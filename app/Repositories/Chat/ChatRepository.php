<?php
namespace App\Repositories\Chat;

// use App\Repositories\Chat\Logic\PublicChatLogic; // - TODO
// use App\Repositories\Chat\Logic\PrivateChatLogic; // - TODO
use App\Repositories\Chat\Logic\CommonChatLogic;

// ----------------------------------------------------------------------
// websocket服务 - 聊天 - 群聊、私聊
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

class ChatRepository
{

    /**
     * 初始化聊天服务
     */
    public static function init_chat_server()
    {
        CommonChatLogic::init_chat_server();
    }

    /**
     * 客户端聊天服务 - 初始化
     * @param int $fd 用户客户端ID
     * @return array
     */
    public static function client_open($fd)
    {
        return CommonChatLogic::client_open($fd);
    }

    /**
     * 客户端聊天服务 - 关闭
     * @param int $fd 用户客户端ID
     * @return array
     */
    public static function client_close($fd)
    {
        return CommonChatLogic::client_close($fd);
    }

    /**
     * 客户端聊天服务 - 处理聊天数据
     * @param int $sender_fd 发送者，客户端ID
     * @param array $sender_data 发送者发送的数据
     * @return array
     */
    public static function handle_message($sender_fd, $sender_data)
    {
        return CommonChatLogic::handle_message($sender_fd, $sender_data);
    }

}
