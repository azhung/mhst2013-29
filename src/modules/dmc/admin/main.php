<?php

    /**
     * @Project Quan Ly Doan Vien
     * @Author MHST2013-29
     * @copyright 2013
     * @createdate 19/7/2013 10:10 AM
     */

    if ( ! defined( 'NV_IS_ADMIN_QL' ) ) die( 'Stop!!!' );
	$page_title = $lang_module['dmc_page_title'];
	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" .NV_OP_VARIABLE . "=lienchi"); die();
	
	$contents = "";
	
	include (NV_ROOTDIR . "/includes/header.php");
	echo nv_admin_theme($contents);
	include (NV_ROOTDIR . "/includes/footer.php");
?>