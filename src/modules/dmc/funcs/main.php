<?php
    /**
     * @Project Quan Ly Doan Vien
     * @Author MHST2013-29
     * @Copyright (C) 2013
     * @Createdate 19/7/2013 10:26 AM
     */
	if ( ! defined( 'NV_IS_MOD_QL' ) ) die( 'Dung lai' );
	$page_title = $module_info['custom_title'];
	$key_words = $module_info['keywords'];
	
	$contents = "Xin chào các bạn";
	
	include ( NV_ROOTDIR . "/includes/header.php" );
	echo nv_site_theme( $contents );
	include ( NV_ROOTDIR . "/includes/footer.php" );
     
?>