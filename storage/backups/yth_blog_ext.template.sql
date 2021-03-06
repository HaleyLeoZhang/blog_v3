-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-02-29 16:26:39
-- 服务器版本： 5.5.62-0ubuntu0.14.04.1
-- PHP 版本： 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `yth_blog_ext`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_footer_marks`
--

CREATE TABLE `admin_footer_marks` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '自增字段',
  `admin_id` int(11) UNSIGNED NOT NULL COMMENT '管理员id，对应 admins 表',
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '邮箱',
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '管理员名称',
  `route` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '路由',
  `method` varchar(4) CHARACTER SET utf8mb4 NOT NULL COMMENT '请求类型',
  `params` varchar(3000) CHARACTER SET utf8mb4 NOT NULL COMMENT '请求参数',
  `ip` varchar(16) CHARACTER SET utf8mb4 NOT NULL COMMENT 'IP',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='panda.admin项目，管理员，行为日志' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `admin_login_logs`
--

CREATE TABLE `admin_login_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `admin_id` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `ip` varchar(16) NOT NULL COMMENT '此次登录的IP信息',
  `location` varchar(200) NOT NULL COMMENT '依据IP，查询出来的地理信息',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台登录日志' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `upload_logs`
--

CREATE TABLE `upload_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `url` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '图片地址',
  `crc32` bigint(32) NOT NULL COMMENT '图片crc32指纹，方便搜索',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'CDN渠道',
  `is_deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否被删除',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='图片上传日志' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `user_deny_ips`
--

CREATE TABLE `user_deny_ips` (
  `id` int(11) NOT NULL,
  `ip` char(16) NOT NULL COMMENT '封禁IP',
  `start_time` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '开关状态,1->已被删除',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='禁过的访问IP' ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `user_hit_logs`
--

CREATE TABLE `user_hit_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `related_id` int(11) UNSIGNED NOT NULL COMMENT '某个模块的关联ID，如，访问的文章ID',
  `type` tinyint(4) UNSIGNED NOT NULL COMMENT '模块类型',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) UNSIGNED DEFAULT '1' COMMENT '有效状态，1->有效，0->无效',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户访问某些模块的日志' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `user_login_logs`
--

CREATE TABLE `user_login_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `ip` varchar(16) NOT NULL COMMENT '此次登录的IP信息',
  `location` varchar(200) NOT NULL COMMENT '依据IP，查询出来的地理信息',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台用户登录日志' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `visitor_foot_marks`
--

CREATE TABLE `visitor_foot_marks` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip` varchar(16) NOT NULL COMMENT '访客IP',
  `url` varchar(150) NOT NULL COMMENT '请求进来的链接地址',
  `location` varchar(100) NOT NULL COMMENT '地理位置信息',
  `header` varchar(3000) DEFAULT NULL COMMENT '请求头部信息，后期处理，会统计业务方向',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='用户足迹' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `visitor_foot_mark_analysis`
--

CREATE TABLE `visitor_foot_mark_analysis` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` char(16) NOT NULL COMMENT 'IP',
  `location` varchar(100) NOT NULL COMMENT '依据IP，查询出来的地理信息',
  `device_type` tinyint(1) NOT NULL COMMENT '设备类型：-2->没有相关信息、-1->其他、0->蜘蛛、1->移动端、2->PC',
  `device_name` varchar(50) NOT NULL COMMENT '设备详细名称',
  `referer` varchar(100) NOT NULL COMMENT '来源站点',
  `target` varchar(100) NOT NULL COMMENT '访问地址',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间（与访客足迹的采集时间保持一致）'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='访客足迹分析';

-- --------------------------------------------------------

--
-- 表的结构 `visitor_look_logs`
--

CREATE TABLE `visitor_look_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `location` int(11) DEFAULT NULL COMMENT 'x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='游客访问文章的频率表' ROW_FORMAT=COMPACT;

--
-- 转储表的索引
--

--
-- 表的索引 `admin_footer_marks`
--
ALTER TABLE `admin_footer_marks`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx-admin_id` (`admin_id`) USING BTREE,
  ADD KEY `idx-route` (`route`(30)) USING BTREE;

--
-- 表的索引 `admin_login_logs`
--
ALTER TABLE `admin_login_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx-admin_id` (`admin_id`) USING BTREE;

--
-- 表的索引 `upload_logs`
--
ALTER TABLE `upload_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx-type` (`type`) USING BTREE;

--
-- 表的索引 `user_deny_ips`
--
ALTER TABLE `user_deny_ips`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `user_hit_logs`
--
ALTER TABLE `user_hit_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx-user_id-related_id` (`user_id`,`related_id`) USING BTREE;

--
-- 表的索引 `user_login_logs`
--
ALTER TABLE `user_login_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx-user_id` (`user_id`) USING BTREE;

--
-- 表的索引 `visitor_foot_marks`
--
ALTER TABLE `visitor_foot_marks`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `visitor_foot_mark_analysis`
--
ALTER TABLE `visitor_foot_mark_analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-device_type` (`device_type`) USING BTREE,
  ADD KEY `idx-created_at` (`created_at`) USING BTREE,
  ADD KEY `idx-ip` (`ip`) USING HASH;

--
-- 表的索引 `visitor_look_logs`
--
ALTER TABLE `visitor_look_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx-location` (`location`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_footer_marks`
--
ALTER TABLE `admin_footer_marks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增字段';

--
-- 使用表AUTO_INCREMENT `admin_login_logs`
--
ALTER TABLE `admin_login_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `upload_logs`
--
ALTER TABLE `upload_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_deny_ips`
--
ALTER TABLE `user_deny_ips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_hit_logs`
--
ALTER TABLE `user_hit_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_login_logs`
--
ALTER TABLE `user_login_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `visitor_foot_marks`
--
ALTER TABLE `visitor_foot_marks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `visitor_foot_mark_analysis`
--
ALTER TABLE `visitor_foot_mark_analysis`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `visitor_look_logs`
--
ALTER TABLE `visitor_look_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
