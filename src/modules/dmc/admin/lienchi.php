<?php

    /**
     * @Project Quan Ly Doan Vien
     * @Author MHST2013-29
     * @copyright 2013
     * @createdate 19/7/2013 10:10 AM
     */

    if ( ! defined( 'NV_IS_ADMIN_QL' ) ) die( 'Stop!!!' );
	$page_title = $lang_module['lc_page_title'];
	
	$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";
	$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
	$my_head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
	$my_head .= "<script type=\"text/javascript\">\n";
	$my_head .= "Shadowbox.init({\n";
	$my_head .= "});\n";
	$my_head .= "</script>\n";
	
	$contents = "";
	$error = "";
	
	$xtpl = new XTemplate("lienchi.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
	$xtpl->assign('LANG', $lang_module);
	//echo "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name;
	$xtpl->assign('URL_DEL', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=lcdel&stt=");
	$xtpl->assign('URL_DEL_BACK', "index.php?" . NV_NAME_VARIABLE . "=" . $module_name. "&" . NV_OP_VARIABLE ."=lienchi" );
		
	//INSERT DATA
	$data = array();
	$data['lc_name'] = filter_text_input( 'lc_name', 'post', '' );
	$data['lc_mota'] = filter_text_input( 'lc_mota', 'post', '' );
	
	if ( ($nv_Request->get_int( 'add', 'post', 0 ) == 1) )
	{
		if ( $data['lc_name'] == "" )
		{
	  		$error = $lang_module['lc_error_insert'];
		}		   	
		else
		{	      	
	
	      	$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_lienchi`
	      	(
	         	`lc_name`, 
	         	`lc_mota`
	      	)
	      	VALUES
	      	(	        	       
		        " . $db->dbescape( $data['lc_name'] ) . ",        
		        " . $db->dbescape( $data['lc_mota'] ) . "
	      	)";
	      	if ( $db->sql_query_insert_id( $query ) )
	      	{
	         	$db->sql_freeresult();
	         	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" .NV_OP_VARIABLE . "=lienchi"); die();
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
		$lienchi = getAllLienChi();
		foreach ($lienchi as $lc) {			
			$xtpl->assign('DATA', $lc);
   			$xtpl->parse('main.loop');
		}
		$xtpl->parse('main');
		$contents = $xtpl->text('main');
	}	
	
	include (NV_ROOTDIR . "/includes/header.php");
	echo nv_admin_theme($contents);		
	include (NV_ROOTDIR . "/includes/footer.php");
?>