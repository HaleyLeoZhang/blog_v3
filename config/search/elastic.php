<?php
return [
    // 开关
    'switch' => env('ELASTIC_SWTICH', 'off'), // off 关, on 开
    // 开发环境
    'dev' => [
        // 域名、ip欧得配置
        'hosts' => [
            env('ELASTIC_DEV_NODE_HOST_PORT', 'localhost:9200'),
        ],
    ],
    // 线上环境
    'pro' => [
        'hosts' => [
            env('ELASTIC_PRO_NODE_1_HOST_PORT', 'localhost:9200'),
            env('ELASTIC_PRO_NODE_2_HOST_PORT', 'localhost:9200'),
        ],
    ],
];
