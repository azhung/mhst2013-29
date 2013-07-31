<?php

    /**
     * @Project Quan Ly Doan Vien
     * @Author MHST2013-29
     * @copyright 2013
     * @createdate 19/7/2013 10:10 AM
     */

    if (!defined('NV_SYSTEM')) die('Stop!!!');
		
	
	$allow_func = array('main');
	define('NV_IS_MOD_QL', true); 
	
	require_once NV_ROOTDIR . "/modules/" . $module_name . '/global.functions.php';
?>