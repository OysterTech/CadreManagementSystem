CREATE DATABASE IF NOT EXISTS `cdms` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `cdms`;

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `department` (`id`, `pid`, `name`, `create_time`, `update_time`) VALUES
(1, 0, '育才中学', '2018-10-25 13:46:19', '2018-10-25 13:46:19'),
(2, 1, '育才中学学生会', '2018-10-25 13:46:38', '2018-10-25 13:46:38'),
(3, 1, '共青团广州市育才中学委员会', '2018-10-25 13:47:13', '2018-10-25 13:47:13'),
(4, 1, '育才中学社团联合会', '2018-10-25 13:47:27', '2018-10-25 13:47:27'),
(5, 3, '团委团务部', '2018-11-02 23:58:38', '2018-11-02 23:58:38');

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '类型',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '记录用户名',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `father_id` int(11) NOT NULL COMMENT '父菜单ID（0为主菜单）',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `icon` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标名（FA）',
  `uri` text COLLATE utf8_unicode_ci COMMENT '链接URL',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` varchar(19) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `menu` (`id`, `father_id`, `name`, `icon`, `uri`, `create_time`, `update_time`) VALUES
(1, 0, '系统管理', 'gears', '', '2018-02-18 04:46:23', '2018-03-02 13:09:30'),
(2, 1, '用户列表', 'user-circle-o', 'admin/user/list', '2018-02-18 04:46:23', ''),
(3, 1, '角色列表', 'users', 'admin/role/list', '2018-02-18 04:46:23', ''),
(4, 1, '菜单管理', 'bars', 'admin/sys/menu/list', '2018-02-18 04:46:23', ''),
(5, 1, '操作记录列表', 'list-alt', 'admin/sys/log/list', '2018-02-18 04:46:23', ''),
(6, 1, '数据库后台', 'database', 'show/jumpout/https%3A%2F%2Fwww.baidu.com', '2018-02-18 04:46:23', '2018-03-15 13:11:57'),
(7, 1, '公告管理', 'bell', '', '2018-02-18 04:46:23', '2018-03-29 22:02:37'),
(8, 1, '修改系统设置', 'gear', 'admin/sys/setting/list', '2018-03-01 21:16:51', '2018-03-03 15:37:11'),
(10, 0, '示例页面', 'file', '', '2018-03-14 06:39:43', '2018-03-14 22:42:10'),
(11, 10, '列表页', 'list', 'show/list', '2018-03-14 06:41:24', '0000-00-00 00:00:00'),
(12, 10, '空白页', 'file-o', 'show/blank', '2018-03-14 06:41:59', '0000-00-00 00:00:00'),
(13, 10, '表单页', 'table', 'show/form', '2018-03-14 06:43:46', '0000-00-00 00:00:00'),
(14, 7, '公告列表', 'list-alt', 'admin/notice/list', '2018-03-14 21:08:11', '2018-03-28 18:14:03'),
(15, 7, '发布新公告', 'bullhorn', 'admin/notice/pub', '2018-03-14 21:08:46', '2018-03-29 22:02:53'),
(16, 1, 'FA图标库', 'font-awesome', 'show/jumpout/http%3A%2F%2Fwww.fontawesome.com.cn%2Ffaicons%2F', '2018-10-24 12:28:45', '0000-00-00 00:00:00'),
(19, 0, '个人资料管理', 'address-card', '', '2018-10-24 12:50:18', '0000-00-00 00:00:00'),
(20, 19, '个人资料卡', 'user-circle', 'profile/myCard', '2018-10-24 12:51:19', '2018-10-27 08:59:36'),
(21, 19, '部员资料', 'users', 'profile/myMember', '2018-10-24 12:53:59', '2018-11-02 15:59:38'),
(22, 0, '奖惩管理', 'trophy', '', '2018-10-25 12:52:43', '0000-00-00 00:00:00'),
(23, 22, '我的奖惩', 'tags', 'reward/my', '2018-10-25 12:55:49', '2018-10-25 20:59:35'),
(24, 22, '录入部员奖惩', 'plus-square', 'reward/add', '2018-10-25 12:56:46', '2018-11-02 16:00:23'),
(25, 0, '工作记录管理', 'tasks', '', '2018-10-25 12:57:12', '0000-00-00 00:00:00'),
(29, 25, '我的记录', 'user-circle-o', '#', '2018-11-01 04:38:39', '0000-00-00 00:00:00'),
(30, 29, '新增记录', 'plus-square-o', 'workLog/my/add', '2018-11-01 04:39:25', '0000-00-00 00:00:00'),
(31, 29, '所有工作记录', 'list', 'workLog/my/list', '2018-11-01 04:40:11', '0000-00-00 00:00:00'),
(32, 25, '部员的工作记录', 'users', '#', '2018-11-01 04:40:33', '2018-11-02 16:00:47'),
(33, 32, '新增记录', 'plus-square-o', 'workLog/member/add', '2018-11-01 04:40:55', '0000-00-00 00:00:00'),
(34, 32, '所有工作记录', 'list', 'workLog/member/choose', '2018-11-01 04:41:32', '2018-11-03 08:32:13');

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `create_user` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `id_card` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `enroll_year` int(4) NOT NULL,
  `class_num` int(2) NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `photo_url` text COLLATE utf8_unicode_ci,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dep_id` int(11) NOT NULL DEFAULT '1',
  `job_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名称',
  `remark` text COLLATE utf8_unicode_ci COMMENT '备注',
  `is_default` int(1) NOT NULL DEFAULT '0' COMMENT '是否为默认角色',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` varchar(19) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色表';

INSERT INTO `role` (`id`, `name`, `remark`, `is_default`, `create_time`, `update_time`) VALUES
(1, '超级管理员', '超级管理员，拥有全部权限', 0, '2018-02-18 01:33:20', '2018-03-02 13:18:08'),
(6, '总书记（教师）', '团委书记，最高领导人', 0, '2018-10-25 13:02:51', '2018-10-25 21:15:18'),
(7, '主席', '学生会主席/团委副书记/社联主席', 0, '2018-10-25 13:12:19', '2018-10-25 21:13:30'),
(8, '部长', '各部门部长', 0, '2018-10-25 13:12:31', '0000-00-00 00:00:00'),
(9, '成员', '普通基层成员', 1, '2018-10-25 13:12:56', '0000-00-00 00:00:00');

CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `menu_id` int(11) NOT NULL COMMENT '菜单ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `role_permission` (`id`, `role_id`, `menu_id`) VALUES
(209, 7, 1),
(210, 7, 7),
(211, 7, 15),
(212, 7, 19),
(213, 7, 20),
(214, 7, 21),
(215, 7, 22),
(216, 7, 23),
(217, 7, 24),
(218, 7, 25),
(219, 7, 29),
(220, 7, 30),
(221, 7, 31),
(222, 7, 32),
(223, 7, 33),
(224, 7, 34),
(225, 6, 1),
(226, 6, 2),
(227, 6, 7),
(228, 6, 14),
(229, 6, 15),
(230, 6, 19),
(231, 6, 21),
(232, 6, 22),
(233, 6, 24),
(234, 6, 25),
(235, 6, 32),
(236, 6, 33),
(237, 6, 34),
(238, 9, 19),
(239, 9, 20),
(240, 9, 22),
(241, 9, 23),
(242, 9, 25),
(243, 9, 29),
(244, 9, 30),
(245, 9, 31),
(246, 1, 1),
(247, 1, 2),
(248, 1, 3),
(249, 1, 4),
(250, 1, 5),
(251, 1, 6),
(252, 1, 7),
(253, 1, 14),
(254, 1, 15),
(255, 1, 8),
(256, 1, 16),
(257, 1, 10),
(258, 1, 11),
(259, 1, 12),
(260, 1, 13),
(261, 1, 19),
(262, 1, 20),
(263, 1, 21),
(264, 1, 22),
(265, 1, 23),
(266, 1, 24),
(267, 1, 25),
(268, 1, 29),
(269, 1, 30),
(270, 1, 31),
(271, 1, 32),
(272, 1, 33),
(273, 1, 34),
(274, 8, 19),
(275, 8, 20),
(276, 8, 21),
(277, 8, 22),
(278, 8, 23),
(279, 8, 24),
(280, 8, 25),
(281, 8, 29),
(282, 8, 30),
(283, 8, 31),
(284, 8, 32),
(285, 8, 33),
(286, 8, 34);

CREATE TABLE `send_mail` (
  `id` int(11) NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `token` text COLLATE utf8_unicode_ci NOT NULL,
  `param` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `chinese_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `setting` (`id`, `name`, `chinese_name`, `value`, `create_time`, `update_time`) VALUES
(1, 'sessionPrefix', 'Session名称前缀', 'YC_CDMS_', '2018-03-05 03:55:19', '2018-10-25 10:16:57'),
(2, 'systemName', '系统名称', '广州育才学生干部管理系统', '2018-03-05 03:55:19', '2018-10-25 10:16:57');

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `nick_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '昵称',
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `salt` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '盐',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `status` int(1) NOT NULL DEFAULT '2' COMMENT '状态(0:禁用,1:正常,2:未激活)',
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号',
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱地址',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `work_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `photo_url` text COLLATE utf8_unicode_ci,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_card` (`id_card`),
  ADD UNIQUE KEY `user_id` (`user_id`);

ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `send_mail`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `work_log`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
ALTER TABLE `role_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;
ALTER TABLE `send_mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `work_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;