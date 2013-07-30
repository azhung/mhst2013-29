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
	$contents .="
		<form method=\"post\">
			<table class=\"tab1\">
		    	<thead>
		        	<tr>
		            	<td colspan=\"2\">Thông tin học sinh mới</td>
		         	</tr>
		      	</thead>
		      	<tbody>
		        	<tr>
		            	<td style=\"width: 150px;\">Tên học sinh</td>
		            	<td style=\"background: #eee;\"><input name=\"hoten\" style=\"width: 470px;\" value=\"" . $data['hoten'] . "\" type=\"text\"></td>
		         	</tr>
		      	</tbody>
		      	<tbody>
		        	<tr>
		            	<td>Ngày sinh</td>
		            	<td><input id=\"ngaysinh\" name=\"ngaysinh\" style=\"width: 470px;\" value=\"" . $data['ngaysinh'] . "\" type=\"text\" /></td>
		         	</tr>
		      	</tbody>		      
		        <tr>
					<td colspan=\"2\" align=\"center\" style=\"background: #eee;\">\n
		               	<input name=\"confirm\" value=\"Lưu\" type=\"submit\">\n
		               	<input type=\"hidden\" name=\"add\" value=\"1\">\n
		            </td>\n
		      	</tr>\n
		   	</table>\n
		</form>\n";	
	
	include (NV_ROOTDIR . "/includes/header.php");
	echo nv_admin_theme($contents);
	include (NV_ROOTDIR . "/includes/footer.php");
?>