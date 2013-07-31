<?php	
	
	/*
	 * @Project: Quan Ly Doan Vien
	 * @Author MHST2013-29
	 * @Copyright 2013
	 * @Createdate 19/7/2013
	 */
	
	if ( ! defined('NV_ADMIN') or ! defined('NV_MAINFILE') ){
		die('Stop!!!');		
	}
	$module_version = array(
		"name" => "Danh mục chung", // Tieu de module
		"modfuncs" => "main" ,
		"is_sysmod" => 0,
		"virtual" => 1,
		"version" => "3.0.01",
		"date" => "Wed, 26 Jan 2011 12:47:15 GMT",
		"author" => "MHST2013-29 (mhst2013-29@googlegroups.com)",
		"note"=>"",
		"uploads_dir" => array(
		   $module_name
		)
	);
?>
