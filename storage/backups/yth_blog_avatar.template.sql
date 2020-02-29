-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-02-29 16:27:56
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
-- 数据库： `yth_blog_avatar`
--

-- --------------------------------------------------------

--
-- 表的结构 `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `secret` char(4) NOT NULL COMMENT '密码 - 盐值，每次生成密码时会重置',
  `password` char(32) NOT NULL COMMENT '密码加盐后',
  `email` varchar(50) NOT NULL COMMENT '邮箱号，可对应多个账号',
  `user_pic` varchar(200) NOT NULL COMMENT '用户头像地址',
  `truename` varchar(50) NOT NULL COMMENT '用户真实姓名',
  `remember_token` char(36) NOT NULL COMMENT '如果一个账号只能登录一次，则每次登录，会删掉上一次记录的登录信息',
  `status` smallint(4) NOT NULL COMMENT '用户状态',
  `google_captchar` varchar(100) NOT NULL DEFAULT '' COMMENT '谷歌验证码绑定字段',
  `user_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '关联users.id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员';

--
-- 转存表中的数据 `admins`
--

INSERT INTO `admins` (`id`, `secret`, `password`, `email`, `user_pic`, `truename`, `remember_token`, `status`, `google_captchar`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'woS3', 'bc3bcf008f9a6ef5c121321c1a9fc5ef', 'hlzblog@vip.qq.com', 'https://i.loli.net/2018/06/28/5b34ed109a682.jpg', '云天河', 'f8dac16e-297e-5fc6-9198-a9961cc1569d', 0, 'J7JUBBOOHC3JTK3A', 1, '2018-08-31 16:03:51', '2020-03-01 00:05:35'),
(2, '9niM', 'faebfe1b3964b04e4be6423cbe5ab72d', 'asd@qqw.csd', 'https://i.loli.net/2018/07/16/5b4c3e21111b7.png', '123123', '-', -10, '', 0, '2018-08-31 16:02:24', '2018-08-31 16:03:35'),
(3, '5CpL', '4bac5ef1ec314e56de48e9bff1e04356', 'hlzblog@qq.asd', 'https://i.loli.net/2018/07/16/5b4c3e210f820.png', '123', '-', -10, '', 0, '2018-08-31 16:03:51', '2018-08-31 16:04:20'),
(4, 'b54U', '80fe42273628a07437a26f7cc8c616cc', 'result@ad.cc', 'https://i.loli.net/2018/07/16/5b4c3e21111b7.png', 'result@ad.cc', '-', -10, '', 0, '2018-08-31 16:04:29', '2018-09-23 01:34:04'),
(5, 'PDvL', '7236fbbd98b16757234625bbc45354ad', 'test@hlzblog.top', 'https://i.loli.net/2018/09/22/5ba66470d3a92.jpg', '展示帐号', '-', -1, '', 0, '2018-09-23 01:34:27', '2019-12-09 02:42:07');

-- --------------------------------------------------------

--
-- 表的结构 `articles`
--

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章内容';

INSERT INTO `articles` (`id`, `title`, `type`, `sticky`, `sequence`, `original`, `is_online`, `content`, `descript`, `cover_url`, `cate_id`, `bg_id`, `raw_content`, `statistic`, `is_deleted`, `updated_at`, `created_at`) VALUES
(0, '', 0, 0, 0, 0, 0, '', '', '', 0, 0, '', 0, 0, '2018-09-21 18:28:11', '2018-09-21 18:28:11');

-- --------------------------------------------------------

--
-- 表的结构 `article_categorys`
--

CREATE TABLE `article_categorys` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '分类名',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章分类';

--
-- 转存表中的数据 `article_categorys`
--

INSERT INTO `article_categorys` (`id`, `title`, `is_deleted`, `created_at`, `updated_at`) VALUES
(3, 'Mysql', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(4, 'Javascript', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(5, 'PHP', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(6, 'HTML5', 1, '2018-09-01 07:04:38', '2018-08-05 07:16:22'),
(7, 'CSS3', 1, '2018-09-01 07:04:31', '2018-08-05 07:16:22'),
(8, 'Linux', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(9, 'Web安全', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(11, 'UI', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(12, 'SEO', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(13, 'Redis', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(14, '生活漫谈', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(15, '书单', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(16, '作品与设计', 0, '2019-11-26 08:53:18', '2018-08-05 07:16:22'),
(17, 'HTTP', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(19, 'JAVA', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(20, '语法专题', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(21, 'Web性能', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(22, '动漫', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(23, 'Golang', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(24, 'react-native', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(25, '物联网', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(26, 'NodeJS', 0, '2018-08-05 07:16:22', '2018-08-05 07:16:22'),
(27, '测试···', 1, '2018-09-01 06:56:35', '2018-09-01 06:55:34'),
(28, '1111', 1, '2018-09-01 07:01:53', '2018-09-01 07:01:41'),
(29, '11', 1, '2018-09-01 07:03:16', '2018-09-01 07:01:57'),
(30, '111', 1, '2018-09-01 07:03:20', '2018-09-01 07:02:43'),
(31, '1212', 1, '2018-09-03 13:57:46', '2018-09-01 07:02:47'),
(32, '12', 1, '2018-09-01 07:04:48', '2018-09-01 07:03:23'),
(33, '1231231', 1, '2018-09-03 13:57:44', '2018-09-01 07:03:28'),
(34, '123', 1, '2018-09-03 13:57:41', '2018-09-01 07:04:25'),
(35, '111', 1, '2018-09-09 11:49:20', '2018-09-09 11:49:14'),
(36, '111', 1, '2018-09-29 05:22:54', '2018-09-21 18:36:27'),
(37, '监控系统', 0, '2018-10-19 06:13:08', '2018-10-19 06:13:08'),
(38, '消息队列', 0, '2019-01-18 07:38:49', '2019-01-18 07:38:49'),
(39, '项目设计', 1, '2019-11-26 08:52:56', '2019-11-26 08:52:46'),
(40, '算法', 0, '2020-02-01 09:37:57', '2020-02-01 09:37:57');

-- --------------------------------------------------------

--
-- 表的结构 `backgrounds`
--

CREATE TABLE `backgrounds` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `url` varchar(150) NOT NULL COMMENT '图片链接',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='背景图';

--
-- 转存表中的数据 `backgrounds`
--

INSERT INTO `backgrounds` (`id`, `url`, `is_deleted`, `updated_at`, `created_at`) VALUES
(6, 'http://img.cdn.hlzblog.top/17-8-13/64417605.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(7, 'http://img.cdn.hlzblog.top/17-8-13/13708819.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(8, 'http://img.cdn.hlzblog.top/17-8-13/43300819.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(9, 'http://img.cdn.hlzblog.top/17-8-13/45283015.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(10, 'http://img.cdn.hlzblog.top/17-8-13/12928371.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(11, 'http://img.cdn.hlzblog.top/17-8-13/234453.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(13, 'http://img.cdn.hlzblog.top/17-8-13/88337888.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(14, 'http://img.cdn.hlzblog.top/17-8-13/37349907.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(15, 'http://img.cdn.hlzblog.top/18-2-10/79090488.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(16, 'http://img.cdn.hlzblog.top/17-8-13/6680945.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(17, 'http://img.cdn.hlzblog.top/17-8-13/80191594.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(18, 'http://img.cdn.hlzblog.top/17-8-13/72326003.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(19, 'http://img.cdn.hlzblog.top/17-8-13/53855456.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(20, 'http://img.cdn.hlzblog.top/17-8-13/78910440.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(22, 'http://img.cdn.hlzblog.top/17-8-13/90716820.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(23, 'http://img.cdn.hlzblog.top/17-8-13/1325223.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(24, 'http://img.cdn.hlzblog.top/17-8-13/31070959.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(26, 'http://img.cdn.hlzblog.top/17-8-13/847172.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(27, 'http://img.cdn.hlzblog.top/17-8-13/70078219.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(28, 'http://img.cdn.hlzblog.top/17-8-13/46102539.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(29, 'http://img.cdn.hlzblog.top/17-8-13/97184645.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(30, 'http://img.cdn.hlzblog.top/17-8-13/41729472.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(31, 'http://img.cdn.hlzblog.top/17-8-13/27947591.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(33, 'http://img.cdn.hlzblog.top/18-2-7/53540060.jpg', 1, '2019-07-15 03:08:39', '0000-00-00 00:00:00'),
(34, 'http://img.cdn.hlzblog.top/18-2-7/63707321.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(35, 'http://img.cdn.hlzblog.top/18-2-7/74292535.jpg', 0, '2018-08-05 07:13:34', '0000-00-00 00:00:00'),
(36, '2222', 1, '2018-09-22 04:39:51', '2018-09-22 04:05:27'),
(37, '11', 1, '2018-09-22 04:39:47', '2018-09-22 04:05:37'),
(38, '1', 1, '2018-09-22 04:37:04', '2018-09-22 04:30:06');

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` int(11) NOT NULL COMMENT 'x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID',
  `parent_id` int(11) UNSIGNED DEFAULT '0' COMMENT '评论父类ID，0表示主楼，其他表示子楼',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '普通用户ID',
  `content` varchar(1000) NOT NULL COMMENT '评论内容',
  `status` tinyint(1) UNSIGNED DEFAULT '1' COMMENT '评论显示状态，1->可用，2->冻结',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='博客评论表';

-- --------------------------------------------------------

--
-- 表的结构 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci COMMENT='laravel队列任务失败列表';

-- --------------------------------------------------------

--
-- 表的结构 `friend_links`
--

CREATE TABLE `friend_links` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '站点名',
  `href` varchar(150) NOT NULL COMMENT '跳转链接',
  `weight` int(11) UNSIGNED DEFAULT '0' COMMENT '权重，从大到小排序，权重相同，不会被覆盖',
  `is_deleted` tinyint(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '软删除，1->已删除',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `friend_links`
--

INSERT INTO `friend_links` (`id`, `title`, `href`, `weight`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '云天河CSDN', 'http://blog.csdn.net/myboyli', 940, 1, '2019-09-17 01:57:39', '2018-08-18 02:10:25'),
(2, '云天河Github', 'https://github.com/HaleyLeoZhang', 1000, 0, '2018-10-06 13:17:22', '2018-08-18 02:10:25'),
(3, '云天河Gitee', 'https://gitee.com/HaleyLeoZhang', 950, 0, '2018-10-06 13:17:32', '2018-08-18 02:10:25'),
(4, '小文', 'http://www.az1314.cn/', 490, 0, '2018-10-06 13:18:04', '2018-08-18 02:10:25'),
(5, '新溪-gordon', 'http://www.zhaoweiguo.com/', 500, 0, '2019-06-28 06:27:24', '2018-08-18 02:10:25'),
(6, '半醒的狐狸‭', 'http://blog.vsonweb.com/', 485, 1, '2018-11-09 01:22:48', '2018-08-18 02:10:25'),
(7, '一日一题', 'http://www.80soho.com', 470, 1, '2019-11-10 13:44:38', '2018-08-18 02:10:25'),
(8, '云天河Mall - v2', 'http://mall.hlzblog.top/', 949, 1, '2018-12-01 08:53:35', '2018-11-13 12:54:21'),
(9, '叶落山城秋', 'https://www.iphpt.com/', 100, 0, '2019-11-14 02:08:12', '2019-11-14 02:08:12');

-- --------------------------------------------------------

--
-- 表的结构 `hlz_auth_group`
--

CREATE TABLE `hlz_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '分组名',
  `status` tinyint(1) DEFAULT '1' COMMENT '可用状态：0->不可用，1可用',
  `rules` varchar(3000) DEFAULT NULL COMMENT '组内包含的规则',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `hlz_auth_group`
--

INSERT INTO `hlz_auth_group` (`id`, `title`, `status`, `rules`, `created_at`, `updated_at`) VALUES
(20, 'ReadOnly', 1, '5,4,51,3,45,40,35,38,49,34,33,41,50,36,48,20,37,15,16', '2018-08-31 16:17:22', '2018-08-31 16:17:22'),
(21, '博文', 1, '19,24,20,33,50,27,21,31,28,32,15,18,29,30,26,16,17,25', '2019-03-25 09:29:27', '2019-03-25 09:29:27'),
(22, '首页', 1, '4,51,3,5,52', '2019-03-25 09:37:59', '2019-03-25 09:37:59');

-- --------------------------------------------------------

--
-- 表的结构 `hlz_auth_group_access`
--

CREATE TABLE `hlz_auth_group_access` (
  `uid` int(10) UNSIGNED NOT NULL COMMENT '用户ID',
  `group_id` mediumint(8) UNSIGNED NOT NULL COMMENT '对应分组ID',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `hlz_auth_group_access`
--

INSERT INTO `hlz_auth_group_access` (`uid`, `group_id`, `updated_at`, `created_at`) VALUES
(5, 20, '2019-08-21 13:34:22', '2019-08-21 13:34:22');

-- --------------------------------------------------------

--
-- 表的结构 `hlz_auth_rule`
--

CREATE TABLE `hlz_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则昵称',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '具体规则',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '可用状态：0->不可用，1->可用',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '额外条件',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `hlz_auth_rule`
--

INSERT INTO `hlz_auth_rule` (`id`, `name`, `title`, `type`, `status`, `condition`, `created_at`, `updated_at`) VALUES
(3, 'admin/hall', '首页/概览/主视图', 1, 1, '', '2019-11-15 09:54:15', '2018-10-21 02:18:09'),
(4, 'sidebar/index', '首页/导航栏', 1, 1, '', '2018-10-21 02:19:47', '2018-10-21 02:19:47'),
(5, 'admin/login_log', '首页/登录日志/主视图', 1, 1, '', '2018-10-21 02:20:04', '2018-10-21 02:20:04'),
(15, 'admin/article/category', '博文/分类/主视图', 1, 1, '', '2019-03-26 01:07:21', '2018-10-21 02:27:03'),
(16, 'admin/article/category_info', '博文/分类/接口/分类列表', 1, 1, '', '2019-03-26 01:07:56', '2018-10-21 02:27:31'),
(17, 'admin/article/category_del', '博文/分类/接口/删除', 1, 1, '', '2019-03-26 01:07:24', '2018-10-21 02:28:39'),
(18, 'admin/article/category_edit', '博文/分类/接口/修改', 1, 1, '', '2019-03-26 01:07:11', '2018-10-21 02:28:59'),
(19, 'admin/article/category_add', '博文/分类/接口/添加', 1, 1, '', '2019-03-26 01:07:28', '2018-10-21 02:29:10'),
(20, 'sidebar/article', '博文/导航栏', 1, 1, '', '2018-10-21 02:30:44', '2018-10-21 02:30:44'),
(21, 'admin/article/detail', '博文/文章/接口/主视图', 1, 1, '', '2018-10-21 02:31:26', '2018-10-21 02:31:26'),
(24, 'admin/article/detail_create_view', '博文/文章/视图/新建', 1, 1, '', '2018-10-21 02:32:45', '2018-10-21 02:32:45'),
(25, 'admin/article/detail_edit_view', '博文/文章/视图/修改', 1, 1, '', '2018-10-21 02:33:04', '2018-10-21 02:33:04'),
(26, 'admin/article/detail_del', '博文/文章/接口/删除', 1, 1, '', '2018-10-21 02:33:45', '2018-10-21 02:33:45'),
(27, 'admin/article/article_check_line', '博文/文章/接口/上下线', 1, 1, '', '2018-10-21 02:33:56', '2018-10-21 02:33:56'),
(28, 'admin/article/detail_edit', '博文/文章/接口/修改', 1, 1, '', '2018-10-21 02:34:33', '2018-10-21 02:34:33'),
(29, 'admin/article/detail_create', '博文/文章/接口/创建', 1, 1, '', '2018-10-21 02:34:41', '2018-10-21 02:34:41'),
(30, 'admin/article/background_del', '博文/背景图/接口/创建', 1, 1, '', '2018-10-21 02:35:25', '2018-10-21 02:35:25'),
(31, 'admin/article/background_edit', '博文/背景图/接口/修改', 1, 1, '', '2018-10-21 02:35:32', '2018-10-21 02:35:32'),
(32, 'admin/article/background_add', '博文/背景图/接口/创建', 1, 1, '', '2018-10-21 02:35:38', '2018-10-21 02:35:38'),
(33, 'admin/article/background', '博文/背景图/主视图', 1, 1, '', '2018-10-21 02:35:58', '2018-10-21 02:35:58'),
(34, 'sidebar/user', '用户/导航栏', 1, 1, '', '2018-10-21 02:36:25', '2018-10-21 02:36:25'),
(35, 'sidebar/visitor', '访客/导航栏', 1, 1, '', '2018-10-21 02:36:37', '2018-10-21 02:36:37'),
(36, 'sidebar/memory', '碎片记忆/导航栏', 1, 1, '', '2018-10-21 02:36:49', '2018-10-21 02:36:49'),
(37, 'sidebar/common', '公共配置/导航栏', 1, 1, '', '2018-10-21 02:37:01', '2018-10-21 02:37:01'),
(38, 'sidebar/system', '系统配置/导航栏', 1, 1, '', '2018-10-21 02:37:11', '2018-10-21 02:37:11'),
(40, 'admin/user/comments', '用户/评论列表/主视图', 1, 1, '', '2018-10-21 02:37:50', '2018-10-21 02:37:50'),
(41, 'admin/user/user_list', '用户/用户概览/主视图', 1, 1, '', '2018-10-21 02:38:03', '2018-10-21 02:38:03'),
(42, 'admin/user/user_list_handle', '用户/用户概览/接口/设置状态', 1, 1, '', '2018-10-21 02:39:19', '2018-10-21 02:39:19'),
(43, 'admin/user/hanld_bind_relation', '用户/用户概览/接口/设置与当前账号的关联', 1, 1, '', '2018-10-21 02:39:37', '2018-10-21 02:39:37'),
(44, 'admin/user/comments_update', '用户/评论列表/接口/设置评论状态', 1, 1, '', '2018-10-21 02:41:31', '2018-10-21 02:41:31'),
(45, 'admin/common/friend_link', '公共配置/友情链接/主视图', 1, 1, '', '2018-10-21 02:42:19', '2018-10-21 02:42:19'),
(47, 'admin/common/friend_link_update', '公共配置/友情链接/接口/更新与创建', 1, 1, '', '2018-10-21 02:43:12', '2018-10-21 02:43:12'),
(48, 'admin/system/pic_bed', '系统配置/图床/视图', 1, 1, '', '2019-02-09 15:32:16', '2019-02-09 15:32:16'),
(49, 'admin/visitor/foot_mark_analysis', '访客/足迹分析/主视图', 1, 1, '', '2019-03-26 01:00:58', '2019-02-09 15:35:47'),
(50, 'admin/article/background_info', '博文/背景图/接口/主视图', 1, 1, '', '2019-02-09 16:10:44', '2019-02-09 16:10:44'),
(51, 'admin/self_info', '首页/帐号操作/主视图', 1, 1, '', '2019-03-26 01:00:33', '2019-03-26 01:00:33'),
(52, 'admin/password_edit', '首页/帐号操作/接口/修改密码', 1, 1, '', '2019-03-26 01:01:40', '2019-03-26 01:01:40');

-- --------------------------------------------------------

--
-- 表的结构 `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_unicode_ci COMMENT='laravel数据库队列';

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='第三方登录用户表';

--
-- 转储表的索引
--

--
-- 表的索引 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-email` (`email`) USING BTREE;

--
-- 表的索引 `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `article_categorys`
--
ALTER TABLE `article_categorys`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `backgrounds`
--
ALTER TABLE `backgrounds`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-location` (`location`) USING BTREE;

--
-- 表的索引 `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `friend_links`
--
ALTER TABLE `friend_links`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `hlz_auth_group`
--
ALTER TABLE `hlz_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `hlz_auth_group_access`
--
ALTER TABLE `hlz_auth_group_access`
  ADD UNIQUE KEY `idx-uid-group_id` (`uid`,`group_id`) USING BTREE,
  ADD KEY `idx-group_id` (`group_id`) USING BTREE,
  ADD KEY `idx-uid` (`uid`) USING BTREE;

--
-- 表的索引 `hlz_auth_rule`
--
ALTER TABLE `hlz_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx-name` (`name`) USING BTREE;

--
-- 表的索引 `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-crc32` (`crc32`) USING BTREE;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '请保留ID等于0的空数据，创建文章页面需要';

--
-- 使用表AUTO_INCREMENT `article_categorys`
--
ALTER TABLE `article_categorys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- 使用表AUTO_INCREMENT `backgrounds`
--
ALTER TABLE `backgrounds`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `friend_links`
--
ALTER TABLE `friend_links`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `hlz_auth_group`
--
ALTER TABLE `hlz_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `hlz_auth_rule`
--
ALTER TABLE `hlz_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- 使用表AUTO_INCREMENT `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
