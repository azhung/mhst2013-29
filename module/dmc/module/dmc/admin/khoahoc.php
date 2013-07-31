<?php

    /**
     * @Project Quan Ly Doan Vien
     * @Author MHST2013-29
     * @copyright 2013
     * @createdate 19/7/2013 10:10 AM
     */

    if ( ! defined( 'NV_IS_ADMIN_QL' ) ) die( 'Stop!!!' );
	$page_title = "Quản lý khóa học";
	
	$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";
	$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
	$my_head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
	$my_head .= "<script type=\"text/javascript\">\n";
	$my_head .= "Shadowbox.init({\n";
	$my_head .= "});\n";
	$my_head .= "</script>\n";
	
	$contents = "";	
	$error = "";
	
	$xtpl = new XTemplate("khoahoc.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
	$xtpl->assign('LANG', $lang_module);
		
	$xtpl->assign('URL_DEL', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=khdel&id=");
	$xtpl->assign('URL_DEL_BACK', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name. "&" . NV_OP_VARIABLE ."=khoahoc" );
		
	//INSERT DATA
	$data = array();
	$data['kh_name'] = filter_text_input( 'kh_name', 'post', '' );
	$data['kh_hdt'] = filter_text_input( 'kh_hdt', 'post', '' );
	//$data['kh_hdt'] = filter_text_input( 'kh_name', 'post', '' );
	$data['kh_ngayvao'] = filter_text_input( 'kh_ngayvao', 'post', '' );
	$data['kh_ngayra'] = filter_text_input( 'kh_ngayra', 'post', '' );
	
	if ($data['kh_hdt'] == 'caodang') {
		$data['kh_hdt'] = "Cao đẳng";				
	} else if ($data['kh_hdt'] == 'daihoc') {
		$data['kh_hdt'] = "Đại học";		
	} else if ($data['kh_hdt'] == 'trungcap') {
		$data['kh_hdt'] = "Trung cấp";
	}
	
	if ( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $data['kh_ngayvao'], $m ) ) {
	    $data['kh_ngayvao'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
	} else {
	    $data['kh_ngayvao'] = "";
	}
	
	if ( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $data['kh_ngayra'], $m ) ) {
	    $data['kh_ngayra'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
	} else {
	    $data['kh_ngayra'] = "";
	}
	
	if ( ($nv_Request->get_int( 'add', 'post', 0 ) == 1) )
	{
		if ( $data['kh_name'] == "" )
		{
	  		//$error = $lang_module['lc_error_insert'];
	  		$error = "Khong duoc";
		}		   	
		else
		{				      
	      	//$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_khoahoc`
	      	$query = "INSERT INTO `nv3_vi_dmc_khoahoc`
	      	(
	         	`kh_name`, `kh_hdt`, `kh_namvao`, `kh_namra`
	      	)
	      	VALUES
	      	(	        	       
		        " . $db->dbescape( $data['kh_name'] ) . ",   
		        " . $db->dbescape( $data['kh_hdt'] ) . ",	        
		        " . $data['kh_ngayvao'] . ",
		        " . $data['kh_ngayra'] . "
	      	)";
	      	if ( $db->sql_query_insert_id( $query ) )
	      	{
	         	$db->sql_freeresult();
	         	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" .NV_OP_VARIABLE . "=khoahoc"); die();
	      	}
			else
	      	{
	        	//$error = $lang_module['lc_error_noinsert'];
	        	$error = "khong the luu duoc";
	      	}
		} 		  		   		   		      		 
	}
	
	//GIAO DIEN
	if( $error )
	{
   		$contents .= "
   			<div class=\"quote\" style=\"width: 780px;\">\n
        		<blockquote class=\"error\">
            		<span>".$error."</span>
           		</blockquote>
          	</div>\n
            <div class=\"clear\">
            </div>";
	}
	else
	{
		$khoahoc = getAllKhoaHoc();
		foreach ($khoahoc as $kh) {			
			$xtpl->assign('DATA', $kh);
   			$xtpl->parse('main.loop');
		}
		$xtpl->parse('main');
		$contents = $xtpl->text('main');
	}
	
	
	include (NV_ROOTDIR . "/includes/header.php");
	echo nv_admin_theme($contents);
	include (NV_ROOTDIR . "/includes/footer.php");
?>