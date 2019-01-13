/*
 Navicat Premium Data Transfer

 Source Server         : Local - dev
 Source Server Type    : MySQL
 Source Server Version : 50633
 Source Host           : 192.168.56.110:3306
 Source Schema         : yth_blog_ext

 Target Server Type    : MySQL
 Target Server Version : 50633
 File Encoding         : 65001

 Date: 13/01/2019 22:26:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_footer_marks
-- ----------------------------
DROP TABLE IF EXISTS `admin_footer_marks`;
CREATE TABLE `admin_footer_marks`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增字段',
  `admin_id` int(11) UNSIGNED NOT NULL COMMENT '管理员id，对应 admins 表',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '邮箱',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '管理员名称',
  `route` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路由',
  `method` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '请求类型',
  `params` varchar(3000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '请求参数',
  `ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'IP',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_id`(`admin_id`) USING BTREE,
  INDEX `route`(`route`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1971 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'panda.admin项目，管理员，行为日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_login_logs
-- ----------------------------
DROP TABLE IF EXISTS `admin_login_logs`;
CREATE TABLE `admin_login_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `ip` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '此次登录的IP信息',
  `location` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '依据IP，查询出来的地理信息',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_id`(`admin_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台登录日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for comic_download_logs
-- ----------------------------
DROP TABLE IF EXISTS `comic_download_logs`;
CREATE TABLE `comic_download_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增',
  `comic_id` tinyint(4) UNSIGNED NOT NULL COMMENT 'comic编号，如，1->一人之下',
  `page` int(11) UNSIGNED NOT NULL COMMENT '第多少话',
  `inner_page` int(11) UNSIGNED NOT NULL COMMENT '这页的第多少张',
  `src` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片地址（目前转存至sm.ms）',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0->不可用，1->可用',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comic_id`(`comic_id`) USING BTREE,
  INDEX `page`(`page`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1230 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for upload_logs
-- ----------------------------
DROP TABLE IF EXISTS `upload_logs`;
CREATE TABLE `upload_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片地址',
  `crc32` bigint(32) NOT NULL COMMENT '图片crc32指纹，方便搜索',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'CDN渠道',
  `is_deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否被删除',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `type`(`type`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 56 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = '图片上传日志' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_deny_ips
-- ----------------------------
DROP TABLE IF EXISTS `user_deny_ips`;
CREATE TABLE `user_deny_ips`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封禁IP',
  `start_time` timestamp(0) NULL DEFAULT NULL COMMENT '开始时间',
  `end_time` timestamp(0) NULL DEFAULT NULL COMMENT '结束时间',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '开关状态,1->已被删除',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `created_at` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '禁过的访问IP' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for user_hit_logs
-- ----------------------------
DROP TABLE IF EXISTS `user_hit_logs`;
CREATE TABLE `user_hit_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `related_id` int(11) UNSIGNED NOT NULL COMMENT '某个模块的关联ID，如，访问的文章ID',
  `type` tinyint(4) UNSIGNED NOT NULL COMMENT '模块类型',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '有效状态，1->有效，0->无效',
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`, `related_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户访问某些模块的日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user_login_logs
-- ----------------------------
DROP TABLE IF EXISTS `user_login_logs`;
CREATE TABLE `user_login_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户ID',
  `ip` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '此次登录的IP信息',
  `location` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '依据IP，查询出来的地理信息',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '前台用户登录日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for visitor_foot_mark_analysis
-- ----------------------------
DROP TABLE IF EXISTS `visitor_foot_mark_analysis`;
CREATE TABLE `visitor_foot_mark_analysis`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` char(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IP',
  `location` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '依据IP，查询出来的地理信息',
  `device_type` tinyint(1) NOT NULL COMMENT '设备类型：-2->没有相关信息、-1->其他、0->蜘蛛、1->移动端、2->PC',
  `device_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '设备详细名称',
  `referer` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '来源站点',
  `target` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '访问地址',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `created_at` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间（与访客足迹的采集时间保持一致）',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `device_type`(`device_type`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE,
  INDEX `created_at`(`created_at`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2546 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '访客足迹分析' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for visitor_foot_marks
-- ----------------------------
DROP TABLE IF EXISTS `visitor_foot_marks`;
CREATE TABLE `visitor_foot_marks`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '访客IP',
  `url` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '请求进来的链接地址',
  `location` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '地理位置信息',
  `header` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '请求头部信息，后期处理，会统计业务方向',
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2549 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户足迹' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for visitor_look_logs
-- ----------------------------
DROP TABLE IF EXISTS `visitor_look_logs`;
CREATE TABLE `visitor_look_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `location` int(11) NULL DEFAULT NULL COMMENT 'x<0表示其他位置,x==0表示留言板，x>0其他表示文章ID',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '更新时间',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `yth_location`(`location`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4530 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '游客访问文章的频率表' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
