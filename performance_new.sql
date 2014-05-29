/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : performance_new

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2014-05-29 21:59:25
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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Group ID',
  `name` varchar(64) DEFAULT NULL COMMENT 'Group Name',
  `short_name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_group_short_name` (`short_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO `group` VALUES ('1', 'Администрирование', 'management');
INSERT INTO `group` VALUES ('2', 'МВССО РУз', 'ministry');
INSERT INTO `group` VALUES ('3', 'Высшие образовательные учреждения', 'universities');
INSERT INTO `group` VALUES ('4', 'Ресурсный Центр \"ZIYO Net\"', 'ziyonet');
INSERT INTO `group` VALUES ('5', '\"Внешние\" организации', 'organizations');
INSERT INTO `group` VALUES ('6', 'AKTB', 'aktb');

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
  `task_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_task_job_user_id` (`user_id`),
  KEY `fk_task_job_organization_id` (`organization_id`),
  KEY `fk_task_job_job_id` (`task_id`),
  CONSTRAINT `fk_task_job_job_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
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
  `group_id` int(11) unsigned DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Parent',
  `name` varchar(255) DEFAULT NULL COMMENT 'Name',
  `short_name` varchar(30) NOT NULL COMMENT 'Short Name',
  `description` varchar(255) DEFAULT NULL COMMENT 'Description',
  `address` varchar(255) DEFAULT NULL COMMENT 'Address',
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `web_site` varchar(255) DEFAULT NULL COMMENT 'Web-site',
  `type` enum('university','ministry','comitte','center') DEFAULT 'university' COMMENT 'Type',
  `region_id` int(11) unsigned DEFAULT NULL COMMENT 'Region',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Created At',
  PRIMARY KEY (`id`),
  KEY `fk_organization_region_id` (`region_id`),
  KEY `fk_organization_parent_id` (`parent_id`),
  KEY `fk_organization_group_id` (`group_id`),
  CONSTRAINT `fk_organization_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_organization_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `organization` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_organization_region_id` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of organization
-- ----------------------------
INSERT INTO `organization` VALUES ('5', '1', null, 'Админы', '', 'Админы', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('7', '1', '5', 'Куратор', '', 'Куратор', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('8', '2', null, 'Управление внедрения информационно-коммуникационных технологий в учебный процесс ', '', 'Управление внедрения информационно-коммуникационных технологий в учебный процесс ', null, '56-36-23', null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('9', '2', null, 'Управление ВУЗами', '', 'Управление ВУЗами', null, null, null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('10', null, null, 'Ректорат', '', 'Ректорат', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('11', '2', null, 'Отдел внешних связей', '', 'Отдел внешних связей (описание)', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('12', '3', null, 'Ташкентский государственный технический университет', '', 'Ташкентский государственный технический университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('13', '3', null, 'Национальный Университет Узбекистана', '', 'Информационный Куратор\r\n\r\nНУУз', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('14', '3', null, 'Ташкентский химико-технологический институт', '', 'Ташкентский химико-технологический институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('15', '3', null, 'Ташкентский автомобильно-дорожный институт', '', 'Ташкентский автомобильно-дорожный институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('16', '3', null, 'Ташкентский государственный институт востоковедения', '', 'Ташкентский государственный институт востоковедения', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('18', '3', null, 'Ташкентский архитектурно-строительный институт', '', 'Ташкентский архитектурно-строительный институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('19', '3', null, 'Узбекский государственный университет мировых языков', '', 'Узбекский государственный университет мировых языков', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('20', '3', null, 'Ташкентский государственный педагогический университет', '', 'Ташкентский государственный педагогический университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('21', '3', null, 'Ташкентский финансовый институт', '', 'Ташкентский финансовый институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('22', '3', null, 'Ташкентский государственный экономический университет', '', 'Ташкентский государственный экономический университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('23', '3', null, 'Ташкентский институт текстильной и легкой промышленности', '', 'Ташкентский институт текстильной и легкой промышленности', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('25', '3', null, 'Андижанский инженерно-экономический институт', '', 'Андижанский инженерно-экономический институт', null, null, null, null, 'university', '2', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('26', '3', null, 'Андижанский государственный педагогический институт языков', '', 'Андижанский государственный педагогический институт языков', null, null, null, null, 'university', '2', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('27', '3', null, 'Андижанский государственный университет', '', 'Андижанский государственный университет', null, null, null, null, 'university', '2', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('28', '3', null, 'Бухарский государственный университет', '', 'Бухарский государственный университет', null, null, null, null, 'university', '3', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('29', '3', null, 'Бухарский технологический институт пищевой и легкой промышленности', '', 'Бухарский технологический институт пищевой и легкой промышленности', null, null, null, null, 'university', '3', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('30', '3', null, 'Джизакский политехнический институт', '', 'Джизакский политехнический институт', null, null, null, null, 'university', '4', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('31', '3', null, 'Каракалпакский государственный университет', '', 'Каракалпакский государственный университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('32', '3', null, 'Каршинский государственный университет', '', 'Каршинский государственный университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('33', '3', null, 'Каршинский инженерно-экономический институт', '', 'Каршинский инженерно-экономический институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('34', '3', null, 'Наманганский государственный университет', '', 'Наманганский государственный университет', null, null, null, null, 'university', '7', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('35', '3', null, 'Наманганский инженерно-педагогический институт', '', 'Наманганский инженерно-педагогический институт', null, null, null, null, 'university', '7', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('36', '3', null, 'Наманганский инженерно-экономический институт', '', 'Наманганский инженерно-экономический институт', null, null, null, null, 'university', '7', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('37', '3', null, 'Ферганский государственный университет', '', 'Ферганский государственный университет', null, null, null, null, 'university', '12', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('38', '3', null, 'Ферганский политехнический институт', '', 'Ферганский политехнический институт', null, null, null, null, 'university', '12', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('39', '3', null, 'Ургенчский государственный университет', '', 'Ургенчский государственный университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('40', '3', null, 'Самаркандский государственный университет', '', 'Самаркандский государственный университет', null, null, null, null, 'university', '8', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('41', '3', null, 'Самаркандский государственный институт иностранных языков', '', 'Самаркандский государственный институт иностранных языков', null, null, null, null, 'university', '8', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('42', '3', null, 'Самаркандский государственный архитектурно-строительный институт', '', 'Самаркандский государственный архитектурно-строительный институт', null, null, null, null, 'university', '8', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('43', '3', null, 'Самаркандский институт экономики и сервиса', '', 'Самаркандский институт экономики и сервиса', null, null, null, null, 'university', '8', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('44', '3', null, 'Термезский государственный университет', '', 'Термезский государственный университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('45', '3', null, 'Гулистанский государственный университет', '', 'Гулистанский государственный университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('46', '3', null, 'Ташкентский Исламский университет', '', 'Ташкентский Исламский университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('47', '3', null, 'Навоийский Государственный Педагогический Институт', '', 'Навоийский Государственный Педагогический Институт', null, null, null, 'www.edu.uz', 'university', '6', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('48', '3', null, 'Нукусский Государственный Педагогический Институт', '', 'Нукусский Государственный Педагогический Институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('49', '3', null, 'Джизакский Государственный педагогический институт', '', 'Джизакский Государственный педагогический институт', null, null, null, null, 'university', '4', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('50', '3', null, 'Ташкентский Государственный Областной Педагогический Институт ', '', 'Ташкентский Государственный Областной Педагогический Институт ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('51', '3', null, 'Кокандский Государственный Педагогический Институт', '', 'Кокандский Государственный Педагогический Институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('53', '3', null, 'Ташкентская Медицинская академия', '', 'Ташкентская Медицинская академия', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('54', '3', null, 'Ташкентский педиатрический Медицинский институт', '', 'Ташкентский педиатрический Медицинский институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('55', '3', null, 'Ташкентский Фармацевтический институт', '', 'Ташкентский Фармацевтический институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('56', '3', null, 'Андижанский Государственный Медицинский Институт', '', 'Андижанский Государственный Медицинский Институт', null, null, null, null, 'university', '2', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('57', '3', null, 'Бухарский Государственный Медицинский Институт', '', 'Бухарский Медицинский Институт', null, null, null, null, 'university', '3', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('58', '3', null, 'Самаркандский Государственный Медицинский Институт', '', 'Самаркандский Государственный Медицинский Институт', null, null, null, null, 'university', '8', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('59', '3', null, 'Ташкентский Государственный институт культуры ', '', 'Ташкентский Государственный институт культуры ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('60', '3', null, 'Узбекская Государственная Консерватория ', '', 'Государственная Консерватория Узбекистана', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('61', '3', null, 'Ташкентский Государственный Институт Искусств ', '', 'Ташкентский Государственный Институт Искусств ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('62', '3', null, 'Ташкентская Государственная  высшая школа национального танца и хореографии', '', 'Ташкентская Государственная  высшая школа национального танца и хореографии', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('63', '3', null, 'Узбекский Государственный институт физической культуры', '', 'Узбекский Государственный институт физической культуры', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('64', '3', null, 'Ташкентский Университет Информационных Технологий', '', 'Ташкентский Университет Информационных Технологий', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('65', '3', null, 'Ташкентский Государственный  Юридический Институт', '', 'Ташкентский Государственный  Юридический Институт', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('66', '3', null, 'Ташкентский институт инженеров железнодорожного транспорта', '', 'Ташкентский Институт Инженеров Транспорта', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('67', '3', null, 'Навоийский Государственный горный институт', '', 'Навоийский Государственный горный институт', null, null, null, null, 'university', '6', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('68', '3', null, 'Ташкентский институт ирригации и мелиорации', '', 'Ташкентский институт ирригации и мелиорации', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('69', '3', null, 'Институт национального художества и дизайна', '', 'Институт национального художества и дизайна', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('70', '3', null, 'Ташкентский Государственный аграрный университет', '', 'Ташкентский Государственный аграрный университет', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('71', '3', null, 'Андижанский Сельскохозяйственный Институт', '', 'Андижанский Сельскохозяйственный Институт', null, null, null, null, 'university', '2', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('72', '3', null, 'Самаркандский Сельскохозяйственный Институт', '', 'Самаркандский Сельскохозяйственный Институт', null, null, null, null, 'university', '8', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('73', '3', null, 'Университет Мировой экономики и дипломатии', '', 'Университет Мировой экономики и дипломатии', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('74', '2', null, 'Кацелярия', '', 'Кацелярия МВССО РУз', 'г. Ташкент', '152-7764', null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('75', '2', null, 'Управление духовно-нравственного воспитания', '', 'Управление духовно-нравственного воспитания ', null, '151-2259', null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('77', '5', null, 'Центр развития высшего и среднего специального образования Республики Узбекистан', '', 'Канцелярия ЦРВССО РУз', null, '55-4597', null, null, 'center', '1', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('79', '2', null, 'Служба охраны труда и социальной защиты', '', 'Служба охраны труда и социальной защиты МВССО РУз', null, '152-7763', null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('80', '2', null, 'Секретариат Колегии МВССО РУз', '', 'Секретариат Колегии МВССО РУз', null, '152-7783', null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('81', '2', null, 'Управление делами ', '', 'Управление делами МВССО РУз', null, '152-7772', null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('82', '2', null, 'Управление финансирования и бухгалтерского учета', '', 'Управление финансирования и бухгалтерского учета', null, '152-77-79', null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('83', '2', null, 'Управление кадрами', '', 'Управление кадрами', null, null, null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('84', '2', null, 'Отдел развития научных исследований', '', 'Отдел развития научных исследований', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('85', '2', null, 'Аппарат Министерства', '', 'Аппарат Министерства', 'Ташкент', null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('86', '3', null, 'Филиал Российской экономической академии им. Г.В. Плеханова', '', 'Филиал Российской экономической академии им. Г.В. Плеханова', 'г. Ташкент', '132-6023', null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('87', '3', null, 'Налоговая Академия ', '', 'Налоговая Академия  - ГНК', 'г. Ташкент', '74-0300', null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('88', '4', null, 'Сектор научно-образовательной информации', '', 'Сектор научно-образовательной информации\r\n\r\nРЦ \"ZIYO Net\" (МВССО РУз)', null, null, null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('89', '4', null, 'Сектор социально-экономической информации', '', 'Сектор социально-экономической информации\r\n\r\nРЦ \"ZIYO Net\" (МВССО РУз)', null, null, null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('90', '4', null, 'Сектор общественно-политической  информации', '', 'Сектор общественно-политической  информации\r\n\r\nРЦ \"ZIYO Net\" (МВССО РУз)', null, null, null, null, 'ministry', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('91', '3', null, 'Пожарная школа МВД РУз', '', 'Пожарная школа МВД РУз', null, '1346637', null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('92', '5', null, 'Государственный Центр Тестирования', '', 'Государственный Центр Тестирования', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('94', '3', '54', 'Нукуский филиал Ташкентского Педиатрического Медицинского Института', '', 'Нукуский филиал Ташкентского Педиатрического Медицинского Института', null, '8 (361) 223-6647', null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('95', '3', null, 'Институт СНБ', '', 'Институт СНБ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('96', '3', '53', 'Ургенчский филиал Ташкентской Медицинской Академии ', '', 'Ургенчский филиал Ташкентской Медицинской Академии ', 'г. Ургенч', null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('97', '3', '53', 'Ферганский филиал Ташкентской Медицинской Академии', '', 'Ферганский филиал Ташкентской Медицинской Академии', 'г. Фергана', null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('98', '3', null, 'Ташкентский Филиал Московского Государственного Университетта ', '', 'Ташкентский Филиал Московского Государственного Университетта ', null, '150-8324', null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('100', '3', null, 'Филиал РГУ Нефти и Газа им. И.М.Губкина', '', 'Филиал РГУ Нефти и Газа им. И.М.Губкина', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('101', '3', '64', 'Каршинский филиал ТУИТ', '', 'Каршинский филиал ТУИТ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('102', '3', '64', 'Нукуский филиал ТУИТ', '', 'Нукуский филиал ТУИТ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('103', '3', '64', 'Самаркандский филиал ТУИТ', '', 'Самаркандский филиал ТУИТ', null, null, null, null, 'university', '8', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('104', '3', '64', 'Ферганский филиал ТУИТ', '', 'Ферганский филиал ТУИТ', null, null, null, null, 'university', '12', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('105', '3', '64', 'Ургенчский филиал ТУИТ', '', 'Ургенчский филиал ТУИТ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('106', '3', '67', 'Зарафшанский филиал НавГГИ', '', 'Зарафшанский филиал НавГГИ', null, null, null, null, 'university', '6', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('107', '3', '67', 'Алмалыкский филиал НавГГИ', '', 'Алмалыкский филиал НавГГИ', null, null, null, null, 'university', '6', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('108', '3', '70', 'Нукуский филиал ТГАУ', '', 'Нукуский филиал ТГАУ', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('109', '3', '61', 'Нукусский филиал Ташкентского Государственного Института Искусств', '', 'Нукусский филиал Ташкентского Государственного Института Искусств', 'г. Нукус, ул. Хурлиман Кыз 37', null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('110', '3', '68', 'Бухарский филиал Ташкентского института ирригации и мелиорации', '', 'Бухарский филиал Ташкентского института ирригации и мелиорации', 'Бухара', null, null, null, 'university', '3', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('111', '3', null, 'Банковско-финансовая академия', '', 'Банковско-финансовая академия', null, null, null, null, 'university', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('112', '3', null, 'Координационно-методический центр по вопросам новейшей истории Узбекистана', '', 'Координационно-методический центр по вопросам новейшей истории Узбекистана', null, '233-37-01', null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('113', '2', null, 'юрист', '', 'юрист', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('114', '6', null, 'TMETJEM', '', 'TMETJEM', null, null, null, null, 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('115', '3', null, 'Центр внедрения электронного образования в образовательных учреждениях', '', 'Центр внедрения электронного образования в образовательных учреждениях', 'Университет. 2,\nТашкент', '2460347', null, 'e-edu.uz', 'center', '14', '2014-05-29 22:27:27');
INSERT INTO `organization` VALUES ('116', '3', null, 'Головной научно-методический центр', '', 'Головной научно-методический центр', null, '245-65-59', null, null, 'center', '14', '2014-05-29 22:27:27');

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
INSERT INTO `region` VALUES ('1', 'Республика Каракалпакстан');
INSERT INTO `region` VALUES ('2', 'Андижанская область');
INSERT INTO `region` VALUES ('3', 'Бухарская область');
INSERT INTO `region` VALUES ('4', 'Джизакская область');
INSERT INTO `region` VALUES ('5', 'Кашкадарьинская область');
INSERT INTO `region` VALUES ('6', 'Навоийская область');
INSERT INTO `region` VALUES ('7', 'Наманганская область');
INSERT INTO `region` VALUES ('8', 'Самаркандская область');
INSERT INTO `region` VALUES ('9', 'Сурхандарьинская область');
INSERT INTO `region` VALUES ('10', 'Сырдарьинская область');
INSERT INTO `region` VALUES ('11', 'Ташкентская область');
INSERT INTO `region` VALUES ('12', 'Ферганская область');
INSERT INTO `region` VALUES ('13', 'Хорезмская область');
INSERT INTO `region` VALUES ('14', 'Ташкент');

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
