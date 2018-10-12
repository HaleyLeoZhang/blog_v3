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

--
-- 转存表中的数据 `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, 'redis', 'email', '{\"id\":\"8iNttgmiGkmYb5Flnj130ozmEJzQChZH\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:17:\\\"App\\\\Jobs\\\\EmailJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:2;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"to\\\";s:16:\\\"myboyli4@163.com\\\";s:5:\\\"title\\\";s:24:\\\"blog v2.1 - 数据备份\\\";s:7:\\\"content\\\";O:8:\\\"stdClass\\\":0:{}}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:5:\\\"email\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\EmailJob\"},\"attempts\":3}', 'ErrorException: preg_match() expects parameter 2 to be string, object given in /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php:2843\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'preg_match() ex...\', \'/data/www/www/b...\', 2843, Array)\n#1 [internal function]: Raven_Breadcrumbs_ErrorHandler->handleError(2, \'preg_match() ex...\', \'/data/www/www/b...\', 2843, Array)\n#2 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(2843): preg_match(\'/[\\\\x80-\\\\xFF]/\', Object(stdClass))\n#3 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(2214): PHPMailer->has8bitChars(Object(stdClass))\n#4 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(1275): PHPMailer->createBody()\n#5 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(1210): PHPMailer->preSend()\n#6 /data/www/www/blog_v2.1/app/Services/Tool/SmtpService.php(73): PHPMailer->send()\n#7 /data/www/www/blog_v2.1/app/Jobs/EmailJob.php(82): App\\Services\\Tool\\SmtpService::run(\'myboyli4@163.co...\', \'blog v2.1 - \\xE6\\x95\\xB0...\', Object(stdClass), \'\', \'\')\n#8 /data/www/www/blog_v2.1/app/Jobs/EmailJob.php(64): App\\Jobs\\EmailJob->send_to_one()\n#9 [internal function]: App\\Jobs\\EmailJob->handle()\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\EmailJob))\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\EmailJob))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\EmailJob), false)\n#16 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'email\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'email\')\n#21 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#22 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#23 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#24 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#26 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#27 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#28 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#29 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 {main}', '2018-08-25 16:58:31'),
(2, 'redis', 'email', '{\"id\":\"8DsiZu3IJ0kvKfXfF2LOsjtPnnPCPnXH\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:17:\\\"App\\\\Jobs\\\\EmailJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:2;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"to\\\";s:16:\\\"myboyli4@163.com\\\";s:5:\\\"title\\\";s:24:\\\"blog v2.1 - 数据备份\\\";s:7:\\\"content\\\";O:8:\\\"stdClass\\\":0:{}}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:5:\\\"email\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\EmailJob\"},\"attempts\":3}', 'ErrorException: Undefined variable: type in /data/www/www/blog_v2.1/app/Jobs/EmailJob.php:60\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined varia...\', \'/data/www/www/b...\', 60, Array)\n#1 /data/www/www/blog_v2.1/app/Jobs/EmailJob.php(60): Raven_Breadcrumbs_ErrorHandler->handleError(8, \'Undefined varia...\', \'/data/www/www/b...\', 60, Array)\n#2 [internal function]: App\\Jobs\\EmailJob->handle()\n#3 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#4 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#5 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\EmailJob))\n#6 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\EmailJob))\n#7 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#8 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\EmailJob), false)\n#9 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'email\', Object(Illuminate\\Queue\\WorkerOptions))\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'email\')\n#14 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#15 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#16 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#17 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 {main}', '2018-08-25 17:00:49'),
(3, 'redis', 'email', '{\"id\":\"vOnB4GZwWgQVzJTCQsoKIM9edWhYyhiK\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:17:\\\"App\\\\Jobs\\\\EmailJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:2;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"to\\\";s:16:\\\"myboyli4@163.com\\\";s:5:\\\"title\\\";s:24:\\\"blog v2.1 - 数据备份\\\";s:7:\\\"content\\\";O:8:\\\"stdClass\\\":0:{}}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:5:\\\"email\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\EmailJob\"},\"attempts\":3}', 'ErrorException: preg_match() expects parameter 2 to be string, object given in /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php:2843\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'preg_match() ex...\', \'/data/www/www/b...\', 2843, Array)\n#1 [internal function]: Raven_Breadcrumbs_ErrorHandler->handleError(2, \'preg_match() ex...\', \'/data/www/www/b...\', 2843, Array)\n#2 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(2843): preg_match(\'/[\\\\x80-\\\\xFF]/\', Object(stdClass))\n#3 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(2214): PHPMailer->has8bitChars(Object(stdClass))\n#4 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(1275): PHPMailer->createBody()\n#5 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(1210): PHPMailer->preSend()\n#6 /data/www/www/blog_v2.1/app/Services/Tool/SmtpService.php(73): PHPMailer->send()\n#7 /data/www/www/blog_v2.1/app/Jobs/EmailJob.php(86): App\\Services\\Tool\\SmtpService::run(\'myboyli4@163.co...\', \'blog v2.1 - \\xE6\\x95\\xB0...\', Object(stdClass), \'\', \'\')\n#8 /data/www/www/blog_v2.1/app/Jobs/EmailJob.php(64): App\\Jobs\\EmailJob->send_to_one()\n#9 [internal function]: App\\Jobs\\EmailJob->handle()\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\EmailJob))\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\EmailJob))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\EmailJob), false)\n#16 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'email\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'email\')\n#21 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#22 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#23 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#24 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#26 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#27 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#28 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#29 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 {main}', '2018-08-25 17:01:22'),
(4, 'redis', 'email', '{\"id\":\"vdID7G5J6niIfUKwmp7QNrPLGUmIj7cl\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:17:\\\"App\\\\Jobs\\\\EmailJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:2;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"to\\\";s:16:\\\"myboyli4@163.com\\\";s:5:\\\"title\\\";s:24:\\\"blog v2.1 - 数据备份\\\";s:7:\\\"content\\\";O:8:\\\"stdClass\\\":0:{}}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:5:\\\"email\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\EmailJob\"},\"attempts\":3}', 'ErrorException: preg_match() expects parameter 2 to be string, object given in /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php:2843\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'preg_match() ex...\', \'/data/www/www/b...\', 2843, Array)\n#1 [internal function]: Raven_Breadcrumbs_ErrorHandler->handleError(2, \'preg_match() ex...\', \'/data/www/www/b...\', 2843, Array)\n#2 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(2843): preg_match(\'/[\\\\x80-\\\\xFF]/\', Object(stdClass))\n#3 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(2214): PHPMailer->has8bitChars(Object(stdClass))\n#4 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(1275): PHPMailer->createBody()\n#5 /data/www/www/blog_v2.1/app/Libs/Smtp/class.phpmailer.php(1210): PHPMailer->preSend()\n#6 /data/www/www/blog_v2.1/app/Services/Tool/SmtpService.php(73): PHPMailer->send()\n#7 /data/www/www/blog_v2.1/app/Jobs/EmailJob.php(86): App\\Services\\Tool\\SmtpService::run(\'myboyli4@163.co...\', \'blog v2.1 - \\xE6\\x95\\xB0...\', Object(stdClass), \'\', \'\')\n#8 /data/www/www/blog_v2.1/app/Jobs/EmailJob.php(64): App\\Jobs\\EmailJob->send_to_one()\n#9 [internal function]: App\\Jobs\\EmailJob->handle()\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\EmailJob))\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\EmailJob))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\EmailJob), false)\n#16 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'email\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'email\')\n#21 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#22 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#23 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#24 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#26 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#27 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#28 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#29 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 {main}', '2018-08-25 17:03:09'),
(5, 'redis', 'email', '{\"id\":\"s8bSg7OXO19k4VxN7CA0nQ9i6JptTdor\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:17:\\\"App\\\\Jobs\\\\EmailJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:2;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"to\\\";s:16:\\\"myboyli4@163.com\\\";s:5:\\\"title\\\";s:24:\\\"blog v2.1 - 数据备份\\\";s:7:\\\"content\\\";s:3737:\\\"&lt;table align=&quot;center&quot; width=&quot;650&quot; border=&quot;0&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; style=&quot;background-color: #ffffff; color: #4A4E5E; font-family: \'微软雅黑\', \'Microsoft Yahei\', \'宋体\', \'simsun\', \'黑体\', Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 29px; max-width: 600px; padding-top: 0px&quot;&gt;\\r\\n    &lt;tbody&gt;\\r\\n        &lt;tr&gt;\\r\\n            &lt;td width=&quot;650&quot; height=&quot;165&quot;&gt;\\r\\n                &lt;img border=&quot;0&quot; height=&quot;144&quot; width=&quot;650&quot; src=&quot;http:\\/\\/img.cdn.hlzblog.top\\/17-11-1\\/90327252.jpg&quot;&gt;\\r\\n            &lt;\\/td&gt;\\r\\n        &lt;\\/tr&gt;\\r\\n        &lt;tr&gt;\\r\\n            &lt;td&gt;\\r\\n                &lt;table width=&quot;650&quot; border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot;&gt;\\r\\n                    &lt;tbody&gt;\\r\\n                        &lt;tr&gt;\\r\\n                            &lt;td width=&quot;55&quot;&gt;&lt;\\/td&gt;\\r\\n                            &lt;td width=&quot;540&quot;&gt;\\r\\n                                &lt;table width=&quot;540&quot; border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot;&gt;\\r\\n                                    &lt;tbody&gt;\\r\\n                                        &lt;tr height=&quot;32&quot;&gt;\\r\\n                                            &lt;td width=&quot;540&quot; height=&quot;32&quot;&gt;&lt;\\/td&gt;\\r\\n                                        &lt;\\/tr&gt;\\r\\n                                        &lt;tr height=&quot;61&quot;&gt;\\r\\n                                            &lt;td&gt;\\r\\n                                                &lt;p style=&quot;font-family: \'微软雅黑\', \'Microsoft Yahei\', \'宋体\', \'simsun\', \'黑体\', Arial, sans-serif !important;&quot;&gt;&lt;span style=&quot;border-bottom-width: 1px; border-bottom-style: dashed; border-bottom-color: rgb(204, 204, 204); z-index: 1; position: static;color:black;font-weight:600;&quot; t=&quot;7&quot; onclick=&quot;return false;&quot; data=&quot;229270575&quot; isout=&quot;1&quot;&gt;已备份 &lt;span style=&quot;color:red;&quot;&gt;20180825.tar.gz&lt;\\/span&gt;&lt;\\/span&gt;\\r\\n                                                &lt;\\/p&gt;\\r\\n                                            &lt;\\/td&gt;\\r\\n                                        &lt;\\/tr&gt;\\r\\n                                        &lt;tr height=&quot;62&quot;&gt;\\r\\n                                            &lt;td&gt;\\r\\n                                                &lt;p style=&quot;font-family: \'微软雅黑\', \'Microsoft Yahei\', \'宋体\', \'simsun\', \'黑体\', Arial, sans-serif !important;&quot;&gt;\\r\\n                                                    &lt;a href=&quot;{:config(\'now_host\')}&quot; style=&quot;font-weight:bolder;color:#4d82dc;text-decoration:none;&quot; target=&quot;_blank&quot;&gt;&lt;span style=&quot;color:#ad91e1;&quot;&gt;来自&lt;\\/span&gt; http:\\/\\/www.hlzblog.top&lt;\\/a&gt;\\r\\n                                                &lt;\\/p&gt;\\r\\n                                            &lt;\\/td&gt;\\r\\n                                        &lt;\\/tr&gt;\\r\\n                                        &lt;tr height=&quot;20&quot;&gt;\\r\\n                                            &lt;td&gt;&lt;\\/td&gt;\\r\\n                                        &lt;\\/tr&gt;\\r\\n                                    &lt;\\/tbody&gt;\\r\\n                                &lt;\\/table&gt;\\r\\n                            &lt;\\/td&gt;\\r\\n                            &lt;td width=&quot;55&quot;&gt;&lt;\\/td&gt;\\r\\n                        &lt;\\/tr&gt;\\r\\n                    &lt;\\/tbody&gt;\\r\\n                &lt;\\/table&gt;\\r\\n            &lt;\\/td&gt;\\r\\n        &lt;\\/tr&gt;\\r\\n    &lt;\\/tbody&gt;\\r\\n&lt;\\/table&gt;\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:5:\\\"email\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\EmailJob\"},\"attempts\":3}', 'Symfony\\Component\\Debug\\Exception\\FatalThrowableError: Undefined class constant \'TYPE_CRONT_BAK_SQL\' in /data/www/www/blog_v2.1/app/Jobs/EmailJob.php:63\nStack trace:\n#0 [internal function]: App\\Jobs\\EmailJob->handle()\n#1 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#2 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#3 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\EmailJob))\n#4 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\EmailJob))\n#5 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#6 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\EmailJob), false)\n#7 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#8 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#9 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'email\', Object(Illuminate\\Queue\\WorkerOptions))\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'email\')\n#12 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#15 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 {main}', '2018-08-25 17:11:57'),
(6, 'redis', 'analysis_visitor_job', '{\"id\":\"jzeoZxWctPDJ7KBDMdmqUc4gKUAOETEO\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:27:\\\"App\\\\Jobs\\\\AnalysisVisitorJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:1;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"ip\\\";s:14:\\\"192.168.56.111\\\";s:6:\\\"header\\\";s:758:\\\"{\\\"cookie\\\":[\\\"End-Token=a58f5b7c36fce1c414e94701aa9d8a51; Hm_lvt_a3e8bb5c7eef342491aa58e9a8539127=1536675971,1537543014,1537605929,1537718937; Hm_lpvt_a3e8bb5c7eef342491aa58e9a8539127=1537765943\\\"],\\\"accept-language\\\":[\\\"zh-CN,zh;q=0.8\\\"],\\\"accept-encoding\\\":[\\\"gzip, deflate\\\"],\\\"referer\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\\\\/article\\\\\\/27.html\\\"],\\\"x-requested-with\\\":[\\\"XMLHttpRequest\\\"],\\\"accept\\\":[\\\"*\\\\\\/*\\\"],\\\"content-type\\\":[\\\"application\\\\\\/x-www-form-urlencoded; charset=UTF-8\\\"],\\\"user-agent\\\":[\\\"Mozilla\\\\\\/5.0 (Windows NT 6.1; WOW64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/58.0.3029.110 Safari\\\\\\/537.36 SE 2.X MetaSr 1.0\\\"],\\\"origin\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\"],\\\"cache-control\\\":[\\\"no-cache\\\"],\\\"pragma\\\":[\\\"no-cache\\\"],\\\"content-length\\\":[\\\"49\\\"],\\\"connection\\\":[\\\"keep-alive\\\"],\\\"host\\\":[\\\"web.test.com\\\"]}\\\";s:3:\\\"url\\\";s:35:\\\"http:\\/\\/web.test.com\\/article\\/27.html\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:20:\\\"analysis_visitor_job\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\AnalysisVisitorJob\"},\"attempts\":3}', 'ErrorException: Undefined variable: location_info in /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php:91\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined varia...\', \'/data/www/www/b...\', 91, Array)\n#1 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(91): Raven_Breadcrumbs_ErrorHandler->handleError(8, \'Undefined varia...\', \'/data/www/www/b...\', 91, Array)\n#2 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(67): App\\Jobs\\AnalysisVisitorJob->get_location()\n#3 [internal function]: App\\Jobs\\AnalysisVisitorJob->handle()\n#4 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#5 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#6 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#7 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#8 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#9 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\AnalysisVisitorJob), false)\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'analysis_visito...\', Object(Illuminate\\Queue\\WorkerOptions))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'analysis_visito...\')\n#15 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#16 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#18 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 {main}', '2018-09-24 05:12:38'),
(7, 'redis', 'analysis_visitor_job', '{\"id\":\"7cbq44yURIaTz6Kz12ush6DScaf87RZO\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:27:\\\"App\\\\Jobs\\\\AnalysisVisitorJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:1;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"ip\\\";s:14:\\\"192.168.56.111\\\";s:6:\\\"header\\\";s:758:\\\"{\\\"cookie\\\":[\\\"End-Token=a58f5b7c36fce1c414e94701aa9d8a51; Hm_lvt_a3e8bb5c7eef342491aa58e9a8539127=1536675971,1537543014,1537605929,1537718937; Hm_lpvt_a3e8bb5c7eef342491aa58e9a8539127=1537765972\\\"],\\\"accept-language\\\":[\\\"zh-CN,zh;q=0.8\\\"],\\\"accept-encoding\\\":[\\\"gzip, deflate\\\"],\\\"referer\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\\\\/article\\\\\\/27.html\\\"],\\\"x-requested-with\\\":[\\\"XMLHttpRequest\\\"],\\\"accept\\\":[\\\"*\\\\\\/*\\\"],\\\"content-type\\\":[\\\"application\\\\\\/x-www-form-urlencoded; charset=UTF-8\\\"],\\\"user-agent\\\":[\\\"Mozilla\\\\\\/5.0 (Windows NT 6.1; WOW64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/58.0.3029.110 Safari\\\\\\/537.36 SE 2.X MetaSr 1.0\\\"],\\\"origin\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\"],\\\"cache-control\\\":[\\\"no-cache\\\"],\\\"pragma\\\":[\\\"no-cache\\\"],\\\"content-length\\\":[\\\"49\\\"],\\\"connection\\\":[\\\"keep-alive\\\"],\\\"host\\\":[\\\"web.test.com\\\"]}\\\";s:3:\\\"url\\\";s:35:\\\"http:\\/\\/web.test.com\\/article\\/27.html\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:20:\\\"analysis_visitor_job\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\AnalysisVisitorJob\"},\"attempts\":3}', 'ErrorException: Undefined variable: location_info in /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php:91\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined varia...\', \'/data/www/www/b...\', 91, Array)\n#1 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(91): Raven_Breadcrumbs_ErrorHandler->handleError(8, \'Undefined varia...\', \'/data/www/www/b...\', 91, Array)\n#2 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(67): App\\Jobs\\AnalysisVisitorJob->get_location()\n#3 [internal function]: App\\Jobs\\AnalysisVisitorJob->handle()\n#4 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#5 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#6 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#7 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#8 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#9 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\AnalysisVisitorJob), false)\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'analysis_visito...\', Object(Illuminate\\Queue\\WorkerOptions))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'analysis_visito...\')\n#15 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#16 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#18 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 {main}', '2018-09-24 05:13:07');
INSERT INTO `failed_jobs` (`id`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(8, 'redis', 'analysis_visitor_job', '{\"id\":\"2DMIHExuB45Bpm8oqcRQPtwprpnLaoAM\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:27:\\\"App\\\\Jobs\\\\AnalysisVisitorJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:1;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"ip\\\";s:14:\\\"192.168.56.111\\\";s:6:\\\"header\\\";s:758:\\\"{\\\"cookie\\\":[\\\"End-Token=a58f5b7c36fce1c414e94701aa9d8a51; Hm_lvt_a3e8bb5c7eef342491aa58e9a8539127=1536675971,1537543014,1537605929,1537718937; Hm_lpvt_a3e8bb5c7eef342491aa58e9a8539127=1537765991\\\"],\\\"accept-language\\\":[\\\"zh-CN,zh;q=0.8\\\"],\\\"accept-encoding\\\":[\\\"gzip, deflate\\\"],\\\"referer\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\\\\/article\\\\\\/27.html\\\"],\\\"x-requested-with\\\":[\\\"XMLHttpRequest\\\"],\\\"accept\\\":[\\\"*\\\\\\/*\\\"],\\\"content-type\\\":[\\\"application\\\\\\/x-www-form-urlencoded; charset=UTF-8\\\"],\\\"user-agent\\\":[\\\"Mozilla\\\\\\/5.0 (Windows NT 6.1; WOW64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/58.0.3029.110 Safari\\\\\\/537.36 SE 2.X MetaSr 1.0\\\"],\\\"origin\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\"],\\\"cache-control\\\":[\\\"no-cache\\\"],\\\"pragma\\\":[\\\"no-cache\\\"],\\\"content-length\\\":[\\\"49\\\"],\\\"connection\\\":[\\\"keep-alive\\\"],\\\"host\\\":[\\\"web.test.com\\\"]}\\\";s:3:\\\"url\\\";s:35:\\\"http:\\/\\/web.test.com\\/article\\/27.html\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:20:\\\"analysis_visitor_job\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\AnalysisVisitorJob\"},\"attempts\":3}', 'ErrorException: preg_match(): Unknown modifier \'(\' in /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php:120\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'preg_match(): U...\', \'/data/www/www/b...\', 120, Array)\n#1 [internal function]: Raven_Breadcrumbs_ErrorHandler->handleError(2, \'preg_match(): U...\', \'/data/www/www/b...\', 120, Array)\n#2 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(120): preg_match(\'/article/(\\\\d+)....\', \'http://web.test...\', NULL)\n#3 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(69): App\\Jobs\\AnalysisVisitorJob->is_article()\n#4 [internal function]: App\\Jobs\\AnalysisVisitorJob->handle()\n#5 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#6 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#7 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#8 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#9 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\AnalysisVisitorJob), false)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'analysis_visito...\', Object(Illuminate\\Queue\\WorkerOptions))\n#15 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'analysis_visito...\')\n#16 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#18 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#19 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#26 {main}', '2018-09-24 05:13:26'),
(9, 'redis', 'analysis_visitor_job', '{\"id\":\"tk9DL0kI0GefZrnEt3WIGiFmnbwbdy9m\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:27:\\\"App\\\\Jobs\\\\AnalysisVisitorJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:1;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"ip\\\";s:14:\\\"192.168.56.111\\\";s:6:\\\"header\\\";s:758:\\\"{\\\"cookie\\\":[\\\"End-Token=a58f5b7c36fce1c414e94701aa9d8a51; Hm_lvt_a3e8bb5c7eef342491aa58e9a8539127=1536675971,1537543014,1537605929,1537718937; Hm_lpvt_a3e8bb5c7eef342491aa58e9a8539127=1537766049\\\"],\\\"accept-language\\\":[\\\"zh-CN,zh;q=0.8\\\"],\\\"accept-encoding\\\":[\\\"gzip, deflate\\\"],\\\"referer\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\\\\/article\\\\\\/27.html\\\"],\\\"x-requested-with\\\":[\\\"XMLHttpRequest\\\"],\\\"accept\\\":[\\\"*\\\\\\/*\\\"],\\\"content-type\\\":[\\\"application\\\\\\/x-www-form-urlencoded; charset=UTF-8\\\"],\\\"user-agent\\\":[\\\"Mozilla\\\\\\/5.0 (Windows NT 6.1; WOW64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/58.0.3029.110 Safari\\\\\\/537.36 SE 2.X MetaSr 1.0\\\"],\\\"origin\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\"],\\\"cache-control\\\":[\\\"no-cache\\\"],\\\"pragma\\\":[\\\"no-cache\\\"],\\\"content-length\\\":[\\\"49\\\"],\\\"connection\\\":[\\\"keep-alive\\\"],\\\"host\\\":[\\\"web.test.com\\\"]}\\\";s:3:\\\"url\\\";s:35:\\\"http:\\/\\/web.test.com\\/article\\/27.html\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:20:\\\"analysis_visitor_job\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\AnalysisVisitorJob\"},\"attempts\":3}', 'ErrorException: preg_match(): Unknown modifier \'(\' in /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php:120\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'preg_match(): U...\', \'/data/www/www/b...\', 120, Array)\n#1 [internal function]: Raven_Breadcrumbs_ErrorHandler->handleError(2, \'preg_match(): U...\', \'/data/www/www/b...\', 120, Array)\n#2 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(120): preg_match(\'/article/(\\\\d+)....\', \'http://web.test...\', NULL)\n#3 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(69): App\\Jobs\\AnalysisVisitorJob->is_article()\n#4 [internal function]: App\\Jobs\\AnalysisVisitorJob->handle()\n#5 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#6 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#7 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#8 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#9 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\AnalysisVisitorJob), false)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'analysis_visito...\', Object(Illuminate\\Queue\\WorkerOptions))\n#15 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'analysis_visito...\')\n#16 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#18 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#19 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#26 {main}', '2018-09-24 05:14:33'),
(10, 'redis', 'analysis_visitor_job', '{\"id\":\"rg6BYRSMnBjbRE57sEOVAayVVr8RSabl\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:27:\\\"App\\\\Jobs\\\\AnalysisVisitorJob\\\":6:{s:7:\\\"\\u0000*\\u0000type\\\";i:1;s:9:\\\"\\u0000*\\u0000object\\\";O:8:\\\"stdClass\\\":3:{s:2:\\\"ip\\\";s:14:\\\"192.168.56.111\\\";s:6:\\\"header\\\";s:758:\\\"{\\\"cookie\\\":[\\\"End-Token=a58f5b7c36fce1c414e94701aa9d8a51; Hm_lvt_a3e8bb5c7eef342491aa58e9a8539127=1536675971,1537543014,1537605929,1537718937; Hm_lpvt_a3e8bb5c7eef342491aa58e9a8539127=1537766111\\\"],\\\"accept-language\\\":[\\\"zh-CN,zh;q=0.8\\\"],\\\"accept-encoding\\\":[\\\"gzip, deflate\\\"],\\\"referer\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\\\\/article\\\\\\/27.html\\\"],\\\"x-requested-with\\\":[\\\"XMLHttpRequest\\\"],\\\"accept\\\":[\\\"*\\\\\\/*\\\"],\\\"content-type\\\":[\\\"application\\\\\\/x-www-form-urlencoded; charset=UTF-8\\\"],\\\"user-agent\\\":[\\\"Mozilla\\\\\\/5.0 (Windows NT 6.1; WOW64) AppleWebKit\\\\\\/537.36 (KHTML, like Gecko) Chrome\\\\\\/58.0.3029.110 Safari\\\\\\/537.36 SE 2.X MetaSr 1.0\\\"],\\\"origin\\\":[\\\"http:\\\\\\/\\\\\\/web.test.com\\\"],\\\"cache-control\\\":[\\\"no-cache\\\"],\\\"pragma\\\":[\\\"no-cache\\\"],\\\"content-length\\\":[\\\"49\\\"],\\\"connection\\\":[\\\"keep-alive\\\"],\\\"host\\\":[\\\"web.test.com\\\"]}\\\";s:3:\\\"url\\\";s:35:\\\"http:\\/\\/web.test.com\\/article\\/27.html\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:20:\\\"analysis_visitor_job\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\",\"commandName\":\"App\\\\Jobs\\\\AnalysisVisitorJob\"},\"attempts\":3}', 'ErrorException: preg_match(): Unknown modifier \'(\' in /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php:119\nStack trace:\n#0 /data/www/www/blog_v2.1/vendor/sentry/sentry/lib/Raven/Breadcrumbs/ErrorHandler.php(34): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'preg_match(): U...\', \'/data/www/www/b...\', 119, Array)\n#1 [internal function]: Raven_Breadcrumbs_ErrorHandler->handleError(2, \'preg_match(): U...\', \'/data/www/www/b...\', 119, Array)\n#2 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(119): preg_match(\'/article/(\\\\d+)\\\\...\', \'http://web.test...\', NULL)\n#3 /data/www/www/blog_v2.1/app/Jobs/AnalysisVisitorJob.php(69): App\\Jobs\\AnalysisVisitorJob->is_article()\n#4 [internal function]: App\\Jobs\\AnalysisVisitorJob->handle()\n#5 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#6 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#7 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(151): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#8 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\AnalysisVisitorJob))\n#9 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(47): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\AnalysisVisitorJob), false)\n#11 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(73): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\RedisJob), Array)\n#12 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(203): Illuminate\\Queue\\Jobs\\Job->fire()\n#13 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(153): Illuminate\\Queue\\Worker->process(\'redis\', Object(Illuminate\\Queue\\Jobs\\RedisJob), Object(Illuminate\\Queue\\WorkerOptions))\n#14 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(100): Illuminate\\Queue\\Worker->runNextJob(\'redis\', \'analysis_visito...\', Object(Illuminate\\Queue\\WorkerOptions))\n#15 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'redis\', \'analysis_visito...\')\n#16 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->fire()\n#17 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Container/Container.php(508): call_user_func_array(Array, Array)\n#18 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(169): Illuminate\\Container\\Container->call(Array)\n#19 /data/www/www/blog_v2.1/vendor/symfony/console/Command/Command.php(261): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#20 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Console/Command.php(155): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(817): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(185): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 /data/www/www/blog_v2.1/vendor/symfony/console/Application.php(116): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 /data/www/www/blog_v2.1/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 /data/www/www/blog_v2.1/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#26 {main}', '2018-09-24 05:15:30');

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
