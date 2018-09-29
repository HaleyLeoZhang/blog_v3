<?php

// - Auth 权限控制

return [

    // - Auth 类配置 - 实时认证
    'AUTH_ON'           => true, // 认证开关
    'AUTH_GROUP'        => 'hlz_auth_group', // 用户组数据表名
    'AUTH_GROUP_ACCESS' => 'hlz_auth_group_access', // 用户-用户组关系表
    'AUTH_RULE'         => 'hlz_auth_rule', // 权限规则表
    'AUTH_USER'         => 'admins', // 用户信息表

    // - 超级用户 id 列表
    'SUPER_LIST'        => [
        1,
    ],
];
