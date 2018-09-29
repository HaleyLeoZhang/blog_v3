<?php

// ----------------------------------------------------------------------
// swoole 配置
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

return [
    

    // 服务器 ip:port 配置
    'server' => [
        'task'      => [
            'ip'               => '0.0.0.0',
            'port'             => '9501',
            // 异步任务 配置
            'task_server_init' => [
                'worker_num'      => 4,
                'daemonize'       => false,
                'max_request'     => 1000,
                'dispatch_mode'   => 2,
                'debug_mode'      => 1,
                'task_worker_num' => 4,
            ],
        ],
        'websocket' => [
            'ip'   => '0.0.0.0',
            'port' => '9502',
        ],
    ],

];
