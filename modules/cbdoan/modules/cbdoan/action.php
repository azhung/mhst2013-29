<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Fri, 10 Aug 2012 16:11:38 GMT
 */

if (!defined('NV_IS_FILE_MODULES'))
	die('Stop!!!');

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_donvi`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chucvu`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_thuchi`";
$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config`";

$sql_create_module = $sql_drop_module;

//Danh sach can bo doan
$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `hoten` varchar(40) NOT NULL,
  `ngsinh` varchar(10) NOT NULL,
  `gtinh` int(1) default 1,
  `avt` varchar(255),
  `nvdoan` varchar(10),
  `dang` int(1) DEFAULT '0',
  `nvdang` varchar(10),
  `quequan` varchar(255),
  `diachi` varchar(255),
  `madvi` int(3) NOT NULL,
  `macvu1` int(3) NOT NULL,
  `macvu2` int(3) NOT NULL,
  `macvu3` int(3) NOT NULL,
  `email` varchar(40),
  `lienchi` varchar(50),
  `kyluat` varchar(50),
  `doanphi` varchar(12),
  `website` varchar(50),
  `nhanxet` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_donvi` (
  `madvi` int(3) NOT NULL AUTO_INCREMENT,
  `tendonvi` varchar(100) NOT NULL,
  `gt_dv` varchar(255),
  PRIMARY KEY (`madvi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chucvu` (
  `macvu` int(3) NOT NULL AUTO_INCREMENT,
  `tenchucvu` varchar(100) NOT NULL,
  `gt_cv` varchar(255),
  PRIMARY KEY (`macvu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config` (
  `toplip` int(1),
  `search` int(1),
  `per_page` int(2)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";

$sql_create_module[] = "INSERT INTO `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config` (`toplip`, `search`, `per_page`) VALUES (1, 1, 10)";
?>