<?php
namespace App\Bussiness\Admin\Logic;

use App\Helpers\Token;
use App\Models\AdminAuth\Admin;
use App\Bussiness\Log\LogBussiness;

class PublicChatLogic
{

    /**
     * 处理聊天逻辑
     * @param string sender_fd 发送消息的人的客户端
     * @param array $data 传输的数据部分
     */
    public static function handle_chat($sender_fd, $data)
    {
        // 搜索客服
        // $receiver_fds = [
        //     $sender_fd, // - TODO，接收者ID
        // ];
        // // 回复数据
        // $send_data = [
        //     'event'=> 'private',
        //     'data' => $data,
        //     // 'data' => [
        //     //     'type' => 'html',
        //     //     'content' => '测试，发送的 HTML',
        //     // ],
        // ];
        // return [
        //     $receiver_fds,
        //     $send_data,
        // ];
    }
}
