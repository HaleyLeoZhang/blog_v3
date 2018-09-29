<?php

namespace App\Console\Commands;

use App\Repositories\Chat\ChatRepository;
use Illuminate\Console\Command;
use LogService;

class SwooleCommond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole {type?}';

    /**
     * 运行此命令行，记得加上 & 使其以守护进程的方式，挂在后台（推荐与队列一样，使用 supervisor ）
     *
     * @var string
     */
    protected $description = '
        开启 swoole 相关服务，使用前，请确认安装 swoole 扩展
        每次修改了逻辑，都别忘记重启服务
    ';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $type = $this->argument('type');
        LogService::info(__CLASS__ . '.start.type.' . $type);
        // 清除在线用户列表
        switch ($type) {
            case 'websocket':
                $this->websocket();
                break;
            default:
                throw new \ApiException('参数输入错误');
        }
        LogService::info(__CLASS__ . '.end');
    }

    /**
     * 监听 websocket
     * - 约定与前端传输数据格式为json
     * - 约定 json 格式为 {"event":"", "data":{...}}
     * @return void
     */
    public function websocket()
    {
        ChatRepository::init_chat_server();
        // 创建websocket服务器对象，监听 0.0.0.0:9502
        $server_conf = config('swoole.server.websocket');

        // 默认，9502 端口 [使用前 请开放该端口]
        $ws = new \swoole_websocket_server($server_conf['ip'], $server_conf['port']);

        // 监听 WebSocket 连接打开事件
        $ws->on('open', function ($ws, $request) {
            $data = ChatRepository::client_open($request->fd);
            // 返回初始配置信息给客户端
            $ws->push($request->fd, json_encode($data['response']));
        });

        // 监听 WebSocket 消息事件
        $ws->on('message', function ($ws, $frame) {
            // 获取数据，并忽略错误的请求
            $sender_data = json_decode($frame->data, true);
            $sender_fd   = $frame->fd; // 发送对象，请求者
            // - DOING
            list($receiver_fds, $response) = ChatRepository::handle_message($sender_fd, $sender_data);
            // 发送数据到指定客户端
            foreach ($receiver_fds as $key => $fd) {
                $ws->push(intval($fd), json_encode($response));
            }
        });

        // 监听WebSocket连接关闭事件
        $ws->on('close', function ($ws, $fd) {
            $data = ChatRepository::client_close($fd);
            $ws->push($fd, json_encode($data));

        });

        // 开始运行程序
        $ws->start();
    }

}
