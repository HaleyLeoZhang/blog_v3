<?php
namespace App\Bussiness\Chat\Logic;

use App\Models\User;
use App\Services\Api\TuringRobotApiService;

class PrivateChatLogic
{
    const USER_ID_TO_ALL          = 0; // 群聊
    const USER_ID_TURNING_PRIVATE = -1; // 图灵-私有聊天
    const USER_ID_TURNING_PUBLIC  = -2; // 图灵-公有聊天

    public static $robot_list = [
        self::USER_ID_TURNING_PRIVATE,
        self::USER_ID_TURNING_PUBLIC,
    ];

    const EVENT = 'private';

    const CHAT_TYPE_TEXT = 'text';
    const CHAT_TYPE_HTML = 'html';

    const CHAT_DEFAULT_ID_PRXFIX = 'hlzblog-2018-08-08-';

    /**
     * 处理聊天逻辑
     * @param string sender_fd 发送消息的人的客户端
     * @param array $data 传输的数据部分
     */
    public static function handle_chat($sender_fd, $data)
    {
        // 搜索回复的用户，客户端 FD
        $receiver_fds = [
            $sender_fd, // - TODO，接收者ID
        ];

        // 回复数据
        $reponse_data = [
            'event' => self::EVENT,
            'data'  => [
                'type'    => 'text',
                'content' => '测试，回复的普通文本',
                'user_id' => '聊天目标用户的ID', // 聊天目标用户：群聊值为 0
            ],
        ];

        // // @CASE: 机器人对话
        if (in_array($data['user_id'], self::$robot_list)) {
            self::robot_chat($sender_fd, $data, $reponse_data);
        } else {
            // // @CASE: 群聊
            if (self::USER_ID_TO_ALL == $data['user_id']) {
                $reponse_data['data'] = [
                    'content' => '云天河小哥哥，正在开发群聊呢，敬请期待...',
                    'user_id' => $data['user_id'], // 聊天目标用户：群聊值为 0
                ];
            }
            $user = User::find($data['user_id']);
            // @CASE: 找不到用户
            if (is_null($user)) {
                $reponse_data['data'] = [
                    'type'    => 'text',
                    'content' => '找不到该用户',
                    'user_id' => $data['user_id'], // 聊天目标用户：群聊值为 0
                ];
            } else {
                $reponse_data['event'] = 'offline';
                // @CASE: 找到用户，但找不到他的在线信息
                $reponse_data['data'] = [
                    'content' => '对方已离线',
                    'user_id' => $data['user_id'], // 聊天目标用户：群聊值为 0
                ];
            }
            \LogService::info('与正常人对话中...');
        }
        return [
            $receiver_fds,
            $reponse_data,
        ];
    }

    /**
     * 与机器人聊天
     * @param int   &$sender_fd 对话链接ID（引用类型）
     * @param array &$data 传输的数据部分（引用类型）
     * @param array $reponse_data 默认返回类型（引用类型）
     * @return void
     */
    protected static function robot_chat(&$sender_fd, &$data, &$reponse_data)
    {
        \LogService::debug('与机器人对话中...');
        if (self::USER_ID_TURNING_PRIVATE == $data['user_id']) {
            $type = TuringRobotApiService::API_TYPE_PRIVATE;
        } else {
            $type = TuringRobotApiService::API_TYPE_PUBLIC;
        }
        $trans_id = self::CHAT_DEFAULT_ID_PRXFIX . $sender_fd;
        $res      = TuringRobotApiService::get_instance()
            ->set_trans_id($trans_id)
            ->set_sentence($data['content'])
            ->request($type);
        if ('news' == $res['type']) {
            $reponse_data['event'] = 'news';
        }
        $reponse_data['data'] = [
            'content' => $res['data'],
            'user_id' => $data['user_id'], // 聊天目标用户：群聊值为 0
        ];
    }
}
