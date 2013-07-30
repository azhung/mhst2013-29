<?php	
	
	/*
	 * @Project: Quan Ly Doan Vien
	 * @Author MHST2013-29
	 * @Copyright 2013
	 * @Createdate 19/7/2013
	 */
	if(!defined('NV_IS_FILE_MODULES')) { die('Stop!!!'); }
	$sql_drop_module = array();
	
	$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_lienchi`";
	$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_khoahoc`";
	$sql_drop_module[] = "DROP TABLE IF EXISTS `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chidoan`";
	
	$sql_create_module = $sql_drop_module;
	
	//Lien Chi
	$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_lienchi` (
		`lc_id` int(11) NOT NULL AUTO_INCREMENT,
		`lc_name` nvarchar(255) NOT NULL,
		`lc_mota` nvarchar(255) NULL,
		PRIMARY KEY(`lc_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	
	//Khoa Hoc
	$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_khoahoc` (
		`kh_id` int(11) NOT NULL AUTO_INCREMENT,
		`kh_name` nvarchar(255) NOT NULL,
		`kh_hdt` nvarchar(255) NOT NULL,
		`kh_namvao` varchar(10) NULL,
		`kh_namra` varchar(10) NULL,
		PRIMARY KEY(`kh_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	
	//Chi Doan
	$sql_create_module[] = "CREATE TABLE `" . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_chidoan` (
		`cd_id` int(11) NOT NULL AUTO_INCREMENT,
		`cd_name` nvarchar(255) NOT NULL,
		`cd_lcid` int(11) NOT NULL,
		PRIMARY KEY(`cd_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8";		
?>	