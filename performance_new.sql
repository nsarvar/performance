/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : performance_new

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2014-05-13 14:48:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `file`
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'File ID',
  `realname` varchar(32) NOT NULL COMMENT 'Real Name',
  `task_id` int(11) unsigned DEFAULT NULL COMMENT 'Task',
  `job_id` int(11) unsigned DEFAULT NULL COMMENT 'Job',
  `description` varchar(128) DEFAULT NULL COMMENT 'Description',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Created At',
  `file_size` int(11) DEFAULT NULL COMMENT 'Size',
  `file_name` int(11) DEFAULT NULL COMMENT 'Name',
  `file_type` varchar(64) DEFAULT NULL COMMENT 'Type',
  PRIMARY KEY (`id`),
  KEY `fk_file_task_id` (`task_id`),
  KEY `fk_file_job_id` (`job_id`),
  CONSTRAINT `fk_file_job_id` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_file_task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of file
-- ----------------------------

-- ----------------------------
-- Table structure for `group`
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` int(11) unsigned NOT NULL COMMENT 'Group ID',
  `name` varchar(64) NOT NULL COMMENT 'Group Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of group
-- ----------------------------

-- ----------------------------
-- Table structure for `job`
-- ----------------------------
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `id` int(11) unsigned NOT NULL COMMENT 'Job ID',
  `organization_id` int(11) unsigned DEFAULT NULL COMMENT 'Organization',
  `content` tinytext NOT NULL COMMENT 'Content',
  `status` enum('rejected','approved','progressing','received','pending') NOT NULL DEFAULT 'pending' COMMENT 'Status',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Updated At',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'User',
  PRIMARY KEY (`id`),
  KEY `fk_task_job_user_id` (`user_id`),
  KEY `fk_task_job_organization_id` (`organization_id`),
  CONSTRAINT `fk_task_job_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_task_job_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of job
-- ----------------------------

-- ----------------------------
-- Table structure for `organization`
-- ----------------------------
DROP TABLE IF EXISTS `organization`;
CREATE TABLE `organization` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Organization ID',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Parent',
  `name` varchar(255) DEFAULT NULL COMMENT 'Name',
  `short_name` varchar(30) NOT NULL COMMENT 'Short Name',
  `description` varchar(255) DEFAULT NULL COMMENT 'Description',
  `address` varchar(255) DEFAULT NULL COMMENT 'Address',
  `web_site` varchar(255) DEFAULT NULL COMMENT 'Web-site',
  `type` enum('university','ministry','comitte','center') DEFAULT 'university' COMMENT 'Type',
  `region_id` int(11) unsigned DEFAULT NULL COMMENT 'Region',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Created At',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_short_name` (`short_name`) USING BTREE,
  KEY `fk_organization_region_id` (`region_id`),
  KEY `fk_organization_parent_id` (`parent_id`),
  CONSTRAINT `fk_organization_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `organization` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_organization_region_id` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of organization
-- ----------------------------

-- ----------------------------
-- Table structure for `period`
-- ----------------------------
DROP TABLE IF EXISTS `period`;
CREATE TABLE `period` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Period ID',
  `name` varchar(32) NOT NULL COMMENT 'Name',
  `status` enum('active','archieved') NOT NULL DEFAULT 'active' COMMENT 'Status',
  `task_count` int(8) NOT NULL DEFAULT '0' COMMENT 'Task Count',
  `period_from` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'From',
  `period_to` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'To',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of period
-- ----------------------------

-- ----------------------------
-- Table structure for `region`
-- ----------------------------
DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `id` int(11) unsigned NOT NULL COMMENT 'Region ID',
  `name` varchar(32) NOT NULL COMMENT 'Name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of region
-- ----------------------------

-- ----------------------------
-- Table structure for `task`
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Task ID',
  `number` varchar(64) NOT NULL COMMENT 'Task Number',
  `type` enum('fishka','xat','buyruq') DEFAULT 'buyruq' COMMENT 'Type',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Parent',
  `group_id` int(11) unsigned DEFAULT NULL COMMENT 'Group',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'User',
  `period_id` int(11) unsigned DEFAULT NULL COMMENT 'Period',
  `status` enum('archived','disabled','enabled') NOT NULL DEFAULT 'enabled' COMMENT 'Status',
  `deadline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Deadline',
  `description` tinytext NOT NULL COMMENT 'Description',
  `attachable` int(1) NOT NULL DEFAULT '1' COMMENT 'Can Attach File',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Created At',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Updated At',
  PRIMARY KEY (`id`),
  KEY `fk_task_user_id` (`user_id`) USING BTREE,
  KEY `fk_task_parent_id` (`parent_id`),
  KEY `fk_task_group_id` (`group_id`),
  KEY `fk_task_period_id` (`period_id`),
  CONSTRAINT `fk_task_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_task_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `task` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_task_period_id` FOREIGN KEY (`period_id`) REFERENCES `period` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_task_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of task
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `login` varchar(30) NOT NULL COMMENT 'Login',
  `password` varchar(128) NOT NULL COMMENT 'Password',
  `name` varchar(128) DEFAULT NULL COMMENT 'Full Name',
  `organization_id` int(11) unsigned DEFAULT NULL COMMENT 'Organization',
  `group_id` int(11) unsigned DEFAULT NULL COMMENT 'Group',
  `email` varchar(64) NOT NULL COMMENT 'Email',
  `telephone` varchar(14) DEFAULT NULL COMMENT 'Phone',
  `mobile` varchar(14) DEFAULT NULL COMMENT 'Mobile Phone',
  `birth_date` timestamp NULL DEFAULT NULL COMMENT 'Birth Date',
  `picture` varchar(255) DEFAULT NULL COMMENT 'Picture',
  `status` int(11) DEFAULT '0' COMMENT 'Status',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Created At',
  `role` enum('moderator','user','superadmin','admin') NOT NULL DEFAULT 'user' COMMENT 'Role',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_login` (`login`) USING BTREE,
  KEY `fk_user_organization_id` (`organization_id`),
  KEY `fk_user_group_id` (`group_id`),
  CONSTRAINT `fk_user_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_organization_id` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'dda3f11ab1d4b505a90133568529fa7c000eb42f83e68a2180c2c4c6063f1ee1779cbbfe1d', 'DevTeam', null, null, 'homidjonov@gmail.com', '2461071', '9979114', '2014-05-13 13:59:52', null, '1', '2014-05-13 13:59:59', 'user');
