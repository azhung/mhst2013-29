<?php

    /**
     * @Project Quan Ly Doan Vien
     * @Author MHST2013-29
     * @copyright 2013
     * @createdate 19/7/2013 10:10 AM
     */

    if ( ! defined( 'NV_IS_ADMIN_QL' ) ) die( 'Stop!!!' );
	$page_title = "Quản lý chi đoàn";
	
	$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";
	$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
	$my_head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
	$my_head .= "<script type=\"text/javascript\">\n";
	$my_head .= "Shadowbox.init({\n";
	$my_head .= "});\n";
	$my_head .= "</script>\n";
	
	$contents = "";
	$error = "";
	
	$xtpl = new XTemplate("chidoan.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
	$xtpl->assign('LANG', $lang_module);
	//echo "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name;
	$xtpl->assign('URL_DEL', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cddel&id=");
	$xtpl->assign('URL_DEL_BACK', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name. "&" . NV_OP_VARIABLE ."=chidoan" );
		
	//INSERT DATA
	$data = array();
	$data['cd_name'] = filter_text_input( 'cd_name', 'post', '' );
	$data['cd_lcid'] = filter_text_input( 'cd_lcid', 'post', '' );
	
	if ( ($nv_Request->get_int( 'add', 'post', 0 ) == 1) )
	{
		if ( $data['cd_name'] == "" )
		{
	  		$error = $lang_module['lc_error_insert'];
		}		   	
		else
		{	      	
	
	      	$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_chidoan`
	      	(
	         	`cd_name`, 
	         	`cd_lcid`
	      	)
	      	VALUES
	      	(	        	       
		        " . $db->dbescape( $data['cd_name'] ) . ",        
		        " . $db->dbescape( $data['cd_lcid'] ) . "
	      	)";
	      	if ( $db->sql_query_insert_id( $query ) )
	      	{
	         	$db->sql_freeresult();
	         	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" .NV_OP_VARIABLE . "=chidoan"); die();
	      	}
			else
	      	{
	        	$error = $lang_module['lc_error_noinsert'];
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
		$chidoan = getAllChiDoan();
		foreach ($chidoan as $cd) {			
			$xtpl->assign('DATA', $cd);
   			$xtpl->parse('main.loop');
		}
		
		$lienchi = getAllLienChi();
		//print($lienchi);
		foreach ($lienchi as $lc) {
			$xtpl->assign('DATA1', $lc);
   			$xtpl->parse('main.loop1');
		}
		
		$xtpl->parse('main');
		$contents = $xtpl->text('main');
	}	
	
	include (NV_ROOTDIR . "/includes/header.php");
	echo nv_admin_theme($contents);
	include (NV_ROOTDIR . "/includes/footer.php");
?>