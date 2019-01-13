-- phpMyAdmin SQL Dump
-- version 4.7.0-beta1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-09-29 03:45:38
-- 服务器版本： 5.6.33-0ubuntu0.14.04.1
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yth_blog_avatar`
--
CREATE DATABASE IF NOT EXISTS `yth_blog_avatar` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yth_blog_avatar`;

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `secret` char(4) NOT NULL COMMENT '密码 - 盐值，每次生成密码时会重置',
  `password` char(32) NOT NULL COMMENT '密码加盐后',
  `email` varchar(50) NOT NULL COMMENT '邮箱号，可对应多个账号',
  `user_pic` varchar(200) NOT NULL COMMENT '用户头像地址',
  `truename` varchar(50) NOT NULL COMMENT '用户真实姓名',
  `remember_token` char(32) NOT NULL COMMENT '如果一个账号只能登录一次，则每次登录，会删掉上一次记录的登录信息',
  `status` smallint(4) NOT NULL COMMENT '用户状态',
  `google_captchar` varchar(100) NOT NULL DEFAULT '' COMMENT '谷歌验证码绑定字段',
  `user_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '关联users.id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员';

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`id`, `secret`, `password`, `email`, `user_pic`, `truename`, `remember_token`, `status`, `google_captchar`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'cypd', '30b354d281e860101407f0a01688c77d', 'test@hlzblog.top', 'https://i.loli.net/2018/06/28/5b34ed109a682.jpg', '云天河', 'b63d2aa0c969361c539a23e2e6a2c053', 0, 'J7JUBBOOHC3JTK3A', 1, '2018-08-31 16:03:51', '2018-09-26 10:37:12'),
(2, '9niM', 'faebfe1b3964b04e4be6423cbe5ab72d', 'asd@qqw.csd', 'https://i.loli.net/2018/07/16/5b4c3e21111b7.png', '123123', '-', -10, '', 0, '2018-08-31 16:02:24', '2018-08-31 16:03:35');

-- --------------------------------------------------------

--
-- 表的结构 `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '请保留ID等于0的空数据，创建文章页面需要',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文本类型，markdown、富文本',
  `sticky` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否置顶',
  `sequence` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '置顶的顺序号：同一顺序，ID小的会被置顶',
  `original` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否原创：1->是 0->不是',
  `is_online` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否上线，1->已上线',
  `content` mediumtext NOT NULL COMMENT '处理后数据',
  `descript` varchar(1000) NOT NULL COMMENT '描述',
  `cover_url` varchar(150) NOT NULL COMMENT '封面图片链接',
  `cate_id` int(11) UNSIGNED NOT NULL COMMENT '类别ID，关联 article_categorys.id',
  `bg_id` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '背景图ID，关联background_lists.id ',
  `raw_content` mediumtext NOT NULL COMMENT '处理前数据',
  `statistic` int(11) UNSIGNED DEFAULT '0' COMMENT '浏览数',
  `is_deleted` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章内容';


INSERT INTO `articles` (`id`, `title`, `type`, `sticky`, `sequence`, `original`, `is_online`, `content`, `descript`, `cover_url`, `cate_id`, `bg_id`, `raw_content`, `statistic`, `is_deleted`, `updated_at`, `created_at`) VALUES
(0, '', 0, 0, 0, 0, 0, '', '', '', 0, 0, '', 0, 0, '2018-09-21 18:28:11', '2018-09-21 18:28:11');

-- --------------------------------------------------------

--
-- 表的结构 `article_categorys`
--

DROP TABLE IF EXISTS `article_categorys`;
CREATE TABLE `article_categorys` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '分类名',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章分类';

-- --------------------------------------------------------

--
-- 表的结构 `backgrounds`
--

DROP TABLE IF EXISTS `backgrounds`;
CREATE TABLE `backgrounds` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `url` varchar(150) NOT NULL COMMENT '图片链接',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='背景图';

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` int(11) NOT NULL COMMENT 'x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID',
  `parent_id` int(11) UNSIGNED DEFAULT '0' COMMENT '评论父类ID，0表示主楼，其他表示子楼',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '普通用户ID',
  `content` varchar(1000) NOT NULL COMMENT '评论内容',
  `status` tinyint(1) UNSIGNED DEFAULT '1' COMMENT '评论显示状态，1->可用，2->冻结',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='博客评论表';

-- --------------------------------------------------------

--
-- 表的结构 `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='laravel队列任务失败列表';


-- --------------------------------------------------------

--
-- 表的结构 `friend_links`
--

DROP TABLE IF EXISTS `friend_links`;
CREATE TABLE `friend_links` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '站点名',
  `href` varchar(150) NOT NULL COMMENT '跳转链接',
  `weight` int(11) UNSIGNED DEFAULT '0' COMMENT '权重，从大到小排序，权重相同，不会被覆盖',
  `is_deleted` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `friend_links`
--

INSERT INTO `friend_links` (`id`, `title`, `href`, `weight`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, '云天河CSDN', 'http://blog.csdn.net/myboyli', 0, 0, '2018-09-23 17:16:06', '2018-08-18 02:10:25'),
(2, '云天河Github', 'https://github.com/HaleyLeoZhang', 0, 0, '2018-09-23 17:16:06', '2018-08-18 02:10:25'),
(3, '云天河Gitee', 'https://gitee.com/HaleyLeoZhang', 0, 0, '2018-09-23 17:16:06', '2018-08-18 02:10:25'),
(4, '小文', 'http://www.az1314.cn/', 0, 0, '2018-09-23 17:16:06', '2018-08-18 02:10:25'),
(5, '新溪', 'http://www.xinxiblog.com:8080/', 0, 0, '2018-09-23 17:16:06', '2018-08-18 02:10:25'),
(6, '半醒的狐狸‭', 'http://blog.vsonweb.com/', 0, 0, '2018-09-23 17:16:06', '2018-08-18 02:10:25'),
(7, '一日一题', 'http://www.80soho.com', 0, 0, '2018-09-23 17:16:06', '2018-08-18 02:10:25');

-- --------------------------------------------------------

--
-- 表的结构 `hlz_auth_group`
--

DROP TABLE IF EXISTS `hlz_auth_group`;
CREATE TABLE `hlz_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '分组名',
  `status` tinyint(1) DEFAULT '1' COMMENT '可用状态：0->不可用，1可用',
  `rules` varchar(3000) DEFAULT NULL COMMENT '组内包含的规则',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hlz_auth_group`
--

INSERT INTO `hlz_auth_group` (`id`, `title`, `status`, `rules`, `updated_at`, `created_at`) VALUES
(20, '云天河测试', 1, '1,2', '2018-08-31 16:17:22', '2018-08-31 16:17:22');

-- --------------------------------------------------------

--
-- 表的结构 `hlz_auth_group_access`
--

DROP TABLE IF EXISTS `hlz_auth_group_access`;
CREATE TABLE `hlz_auth_group_access` (
  `uid` int(10) UNSIGNED NOT NULL COMMENT '用户ID',
  `group_id` mediumint(8) UNSIGNED NOT NULL COMMENT '对应分组ID',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hlz_auth_rule`
--

DROP TABLE IF EXISTS `hlz_auth_rule`;
CREATE TABLE `hlz_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则昵称',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '具体规则',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '可用状态：0->不可用，1->可用',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '额外条件',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hlz_auth_rule`
--

INSERT INTO `hlz_auth_rule` (`id`, `name`, `title`, `type`, `status`, `condition`, `updated_at`, `created_at`) VALUES
(1, 'asd', 'asd', 1, 1, '', '2018-08-31 16:14:46', '2018-08-31 16:14:46'),
(2, 'asdghjgh', 'asdjghj', 1, 1, '', '2018-08-31 16:14:49', '2018-08-31 16:14:49');

-- --------------------------------------------------------

--
-- 表的结构 `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='laravel数据库队列';

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `oauth_key` varchar(50) NOT NULL COMMENT '第三方的识别号',
  `crc32` bigint(32) UNSIGNED DEFAULT NULL COMMENT 'oauth_key 与 type 字段值拼接为一个字符后，计算的crc32值，用于用户搜索',
  `type` tinyint(1) NOT NULL COMMENT '第三方类别',
  `name` varchar(50) NOT NULL COMMENT '用户昵称',
  `pic` varchar(150) NOT NULL COMMENT '用户头像',
  `remember_token` char(32) DEFAULT NULL COMMENT '如果一个账号只能登录一次，则每次登录，会删掉上一次记录的登录信息',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户状态：0->正常，-1->锁定，-10->注销',
  `is_deleted` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '软删除，1->已删除',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间、最后登录时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='第三方登录用户表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_categorys`
--
ALTER TABLE `article_categorys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backgrounds`
--
ALTER TABLE `backgrounds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`location`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_links`
--
ALTER TABLE `friend_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hlz_auth_group`
--
ALTER TABLE `hlz_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hlz_auth_group_access`
--
ALTER TABLE `hlz_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `hlz_auth_rule`
--
ALTER TABLE `hlz_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crc32` (`crc32`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '请保留ID等于0的空数据，创建文章页面需要', AUTO_INCREMENT=62;
--
-- 使用表AUTO_INCREMENT `article_categorys`
--
ALTER TABLE `article_categorys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- 使用表AUTO_INCREMENT `backgrounds`
--
ALTER TABLE `backgrounds`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- 使用表AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- 使用表AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `friend_links`
--
ALTER TABLE `friend_links`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `hlz_auth_group`
--
ALTER TABLE `hlz_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `hlz_auth_rule`
--
ALTER TABLE `hlz_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
