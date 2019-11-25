<?php
namespace App\Bussiness\Chat\Logic;

use App\Bussiness\Chat\Logic\PrivateChatLogic;
use Illuminate\Support\Facades\Redis;

class CommonChatLogic
{
    // 聊天类型
    private static $event_list = [
        'init', // 客户端，获取在线用户列表
        'private', // 私聊
        'public', // 群聊
        'customer_service', // 客服
        'online', // 在线时，同步用户信息
        'offline', // 用户离线
        'news', // 图灵机器人，输出列表数据
    ];

    const PRIFIX_ONLIHNE  = 'chat:user:';
    const PRIFIX_OFFLIHNE = 'chat:fd:';

    const RECEIVER_FDS = 0; // 接收用户ID
    const RESPONSE     = 1; // 用户获取到的数据

    public static function init_chat_server()
    {
        // - 删除所有用户的在线记录
        \LogService::info('Swoole.init.success');
    }

    public static function client_open($fd)
    {
        // 初始化用户
        // - TODO
        // - 获取在线用户列表
        $data['response'] = [
            'event' => 'init',
            'data'  => [
                'user_list' => [], // 获取在线用户列表
            ],
        ];
        \LogService::info('Swoole.client.open.fd.' . $fd);

        return $data;
    }

    /**
     * @return array
     */
    public static function client_close($fd)
    {
        // - 删除这个用户的在线记录
        $data = [
            'event' => 'close',
            'data'  => [],
        ];
        self::offline_status($fd);
        \LogService::info('Swoole.client.closed.fd.' . $fd);
        return $data;
    }

    public static function handle_message($sender_fd, $sender_data)
    {
        \LogService::debug('Swoole.client.data', [
            'sender_fd'   => $sender_fd,
            'sender_data' => $sender_data,
        ]);

        $event = $sender_data['event'] ?? '';
        $data  = $sender_data['data'] ?? null;

        // - 初始化数据
        $back = [
            // 回复给客户端 的 ID 列表
            self::RECEIVER_FDS => [
                $sender_fd,
            ],
            self::RESPONSE     => [
                // 事件，默认返回错误事件
                'event' => 'error',
                'data'  => null,
            ],
        ];

        \LogService::debug('event.'.$event);

        if (!in_array($event, self::$event_list)) {
            return $back;
        }

        switch ($event) {
            case 'private':
                list($back[self::RECEIVER_FDS], $back[self::RESPONSE]) =
                PrivateChatLogic::handle_chat($sender_fd, $data);
                break;
            case 'public':
                # code...
                break;
            case 'customer_service':
                # code...
                break;
            case 'online':
                # 同步上线状态
                self::online_status($sender_fd, $data['self_id']);
                break;

            default:
                # code...
                break;
        }

        return $back;
    }

    /**
     *
     * @param int $fd 连接号ID
     * @param int $self_id 个人ID，如果没登录，就是一个随机的负数
     */
    public static function online_status($fd, $self_id)
    {
        $token_name     = self::PRIFIX_ONLIHNE . $self_id;
        $token_off_name = self::PRIFIX_OFFLIHNE . $fd;
        Redis::set($token_name, $fd);
        Redis::set($token_off_name, $self_id);
        \LogService::info('online_status.done');
    }

    /**
     * 用户离线
     * @param int $fd 连接号ID
     */
    public static function offline_status($fd)
    {
        $token_off_name = self::PRIFIX_OFFLIHNE . $fd;
        $self_id        = Redis::get($token_off_name);
        $token_name     = self::PRIFIX_ONLIHNE . $self_id;
        Redis::del($token_off_name);
        Redis::del($token_name);
    }

}
