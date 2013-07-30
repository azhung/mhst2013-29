<?php

    /**
     * @Project Quan Ly Doan Vien
     * @Author MHST2013 - 29
     * @Copyright 2011
     * @createdate 26/01/2011 10:08 AM
     */

    if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

	$submenu['lienchi'] = "Liên chi đoàn";
	$submenu['khoahoc'] = "Khóa học";
	$submenu['chidoan'] = "Chi đoàn";

	$allow_func = array('main', 'lienchi', 'khoahoc', 'chidoan', 'lcdel', 'khdel');	
	
	define( 'NV_IS_ADMIN_QL', true );
	require_once NV_ROOTDIR . "/modules/" . $module_name . '/global.functions.php';
?>