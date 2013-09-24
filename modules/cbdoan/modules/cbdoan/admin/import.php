<?php

/**
 * @Project NUKEVIET 3.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];

global $module_file, $lang_module, $module_info;

$xtpl = new XTemplate( "import.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'IMP_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "" );

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "";
$xtpl->assign( 'ACTION', $url );

$error = array();
global $error;
$insert = 0;
$update = 0;
$line = 0;
$idok_ins = array();
$idok_upd = array();

//Chen danh sach can bo
if ( $nv_Request->isset_request ( 'im_dscb', 'post' ) )
{
    $data = array();  
    if ( $_FILES['cbdoan']['tmp_name'])  
    {  
        $dom = DOMDocument::load( $_FILES['cbdoan']['tmp_name'] );  
        $rows = $dom->getElementsByTagName( 'Row' );  
    	$tde = array();
    	foreach ( $rows as $row)
    	{ 
        	$cells = $row->getElementsByTagName( 'Cell' );  
    		$datarow = array();  
    		foreach ( $cells as $cell )
    		{  
    	   		if ( $line == 0 )
    	   		{
    	      		$tde[] = $cell->nodeValue;
    	   		}
    	   		else
    	   		{
    	   			$datarow [] = $cell->nodeValue;
    	   		} 
    	 	}  
    		$data [] = $datarow;  
    		$line = $line + 1;      
    	}
    
    	foreach( $data as $row ) 
    	{  
    		$dscb = array();
    		$i = 0;
            $j = 0;
    		if (isset( $row[0] ) )
    		{
        		foreach( $row as $item ) 
        		{
        			$dscb[$i] = $item;
                    if($dscb[$i] == "NULL")
                    {
                        $dscb[$i] = "";
                    }
                    $i = $i + 1;
        		} 
        
                if(!empty($dscb[0]) && !empty($dscb[1]) && !empty($dscb[2]) && $dscb[10] != "" && $dscb[11] != "" )
                {
                    //Xac dinh giao vien da co hay chua
                    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id` = " . $dscb[0] . "";
                    $result = $db->sql_query( $sql );
                    $num = $db->sql_numrows($result);
                    
                    //kt chuc vu 2,3
                    if($dscb[12] == "")
                    {
                        $dscb[12] = 0;
                    }
                    
                    if($dscb[13] == "")
                    {
                        $dscb[13] = 0;
                    }
                    
                    //gioi tinh phai la so 1 hoac 0
                    if(!is_numeric($dscb[3]))
                    {
                        $error['gtinh'] = "ID: [" . $dscb[0] . "] " . $lang_module['e_gt'];
                    }
                    
                    //Dang phai la so 1 hoac 0
                    if(!is_numeric($dscb[6]))
                    {
                        $error['dang'] = "ID: [" . $dscb[0] . "] " . $lang_module['e_dang'];
                    }
                    
                    //chua vao dang thi khong nhap ngay vao dang
                    if($dscb[6] == 0 && $dscb[7] != "")
                    {
                        $error['no_dang'] = "ID: [" . $dscb[0] . "] " . $lang_module['no_dang'];
                    }
                    
                    //ma don vi phai la so
                    if(!is_numeric($dscb[10]))
                    {
                        $error['e_dv'] = "ID: [" . $dscb[0] . "] " . $lang_module['e_dv'];
                    }
                    
                    //ma chuc vu phai la so
                    if(!is_numeric($dscb[11]) OR !is_numeric($dscb[12]) OR !is_numeric($dscb[13]))
                    {
                        $error['e_cv'] = "ID: [" . $dscb[0] . "] " . $lang_module['e_cv'];
                    }
                    
                    //ktra avt
                    if($dscb[4] == "")
                    {
                        $dscb[4] = NV_BASE_SITEURL . "images/nophoto.png";
                    }
                    
                    //Dinh dang dia chi web
                    if ( $dscb[18] != "" )
                    {
                        if ( ! preg_match( "#^(http|https|ftp|gopher)\:\/\/#", $dscb[18] ) )
                        {
                            $dscb[18] = "http://" . $dscb[18];
                        }
                        if ( ! nv_is_url( $dscb[18] ) )
                        {
                            $dscb[18] = "";
                        }
                    }
                    
                    //Xu ly cac ky tu xuong dong trong textarea
                    $dscb[19] = nv_nl2br( $dscb[19], "<br />" );
                
                    //Kiem tra loi
                    //Check loi ngay sinh
                    if(strlen($dscb[2]) != 10 )
                    {
                        $error['format_ngsinh'] = "ID: [" . $dscb[0] . "] " . $lang_module['format_ngsinh'];
                    }
                    
                    //Check loi ngay vao doan
                    if(!empty($dscb[5]) && strlen($dscb[5]) != 10 )
                    {
                        $error['format_nvdoan'] = "ID: [" . $dscb[0] . "] " . $lang_module['format_nvdoan'];
                    }
                    
                    //Check loi ngay vao dang
                    if(!empty($dscb[7]) && strlen($dscb[7]) != 10 )
                    {
                        $error['format_nvdang'] = "ID: [" . $dscb[0] . "] " . $lang_module['format_nvdang'];
                    }
                    
                    //Check loi don vi
                    if($dscb[10] == 0)
                    {
                        $error['no_dvi'] ="ID: [" . $dscb[0] . "] " .  $lang_module['no_dvi'];
                    }
                    
                    //Check loi chuc vu
                    if($dscb[11] == 0)
                    {
                        $error['no_cvu'] = "ID: [" . $dscb[0] . "] " . $lang_module['no_cvu'];
                    }
                    if($dscb[11] == $dscb[12] OR $dscb[11] == $dscb[13] OR !empty($dscb[12]) && !empty($dscb[13]) && $dscb[12] == $dscb[13])
                    {
                        $error['tr_cvu'] = "ID: [" . $dscb[0] . "] " . $lang_module['tr_cvu'];
                    }
                    
                    //Kiem tra dinh dang email
                    $pattern = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
                    $mailStr = $dscb[14];
                    if(( !empty($dscb[14]) && preg_match($pattern, $mailStr)==0) ) 
                    {
                        $error['format_email'] = "ID: [" . $dscb[0] . "] " . $lang_module['format_email'];
                    }
                    
                    //Kiem tra so dien thoai
                    if(!empty($dscb[17]) && strlen($dscb[17]) <10  or $dscb[17] && !is_numeric($dscb[17]))
                    {
                        $error['format_phone'] = "ID: [" . $dscb[0] . "] " . $lang_module['format_phone'];
                    }
                    
                    if(empty($error))
                    {
                        if(!$num)
                        {
                            $idok_ins[] = $dscb[0]; 
                            $sql_insert = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "` (
                                    `id`, `hoten`, `ngsinh`, `gtinh`, `avt`, `nvdoan`, `dang`, `nvdang`, `quequan`, 
                                    `diachi`, `madvi`, `macvu1`, `macvu2`, `macvu3`, `email`, `yahoo`, `skype`, `phone`, `website`, `tomtat`) 
                                    VALUES(
                            		" . $db->dbescape( $dscb[0] ) . ", 
                            		" . $db->dbescape( $dscb[1] ) . ",
                            		" . $db->dbescape( $dscb[2] ) . ",
                            		" . $dscb[3] . ",
                                    " . $db->dbescape( $dscb[4] ) . ",
                                    " . $db->dbescape( $dscb[5] ) . ",            
                                    " . $dscb[6] . ",
                                    " . $db->dbescape( $dscb[7] ) . ",            
                                    " . $db->dbescape( $dscb[8] ) . ",
                                    " . $db->dbescape( $dscb[9] ) . ",
                                    " . $dscb[10] . ",
                                    " . $dscb[11] . ",
                                    " . $dscb[12] . ",
                                    " . $dscb[13] . ",
                                    " . $db->dbescape( $dscb[14] ) . ",
                                    " . $db->dbescape( $dscb[15] ) . ",
                                    " . $db->dbescape( $dscb[16] ) . ",
                                    " . $db->dbescape( $dscb[17] ) . ",
                                    " . $db->dbescape( $dscb[18] ) . ",
                                    " . $db->dbescape( $dscb[19] ) . "
                            		)";
                              $result = $db->sql_query($sql_insert);
                              if($result)
                              {
                                    $insert ++;
                                    $xtpl->assign( 'IM_CB', $lang_module['ins'] . $insert . " -      ID:");
                              }
                              else
                              {
                                    $error['csdl'] = $lang_module['csdl'];
                              }
                        }
                        else
                        {        
                            $idok_upd[] = $dscb[0];
                            $sql_update = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET
                                    `hoten` = " . $db->dbescape( $dscb[1] ) . ",
                                    `ngsinh` = " . $db->dbescape( $dscb[2] ) . ",
                                    `gtinh` = " . $db->dbescape( $dscb[3] ) . ",
                                    `avt` = " . $db->dbescape( $dscb[4] ) . ",
                                    `nvdoan` = " . $db->dbescape( $dscb[5] ) . ",            
                                    `dang` = " . $db->dbescape( $dscb[6] ) . ",
                                    `nvdang` = " . $db->dbescape( $dscb[7] ) . ",            
                                    `quequan` = " . $db->dbescape( $dscb[8] ) . ",
                                    `diachi` = " . $db->dbescape( $dscb[9] ) . ",
                                    `madvi` = " . $dscb[10] . ",
                                    `macvu1` = " . $dscb[11] . ",
                                    `macvu2` = " . $dscb[12] . ",
                                    `macvu3` = " . $dscb[13] . ",
                                    `email` = " . $db->dbescape( $dscb[14] ) . ",
                                    `yahoo` = " . $db->dbescape( $dscb[15] ) . ",
                                    `skype` = " . $db->dbescape( $dscb[16] ) . ",
                                    `phone` = " . $db->dbescape( $dscb[17] ) . ",
                                    `website` = " . $db->dbescape( $dscb[18] ) . ",
                                    `tomtat` = " . $db->dbescape( $dscb[19] ) . "
                                    WHERE `id` = " . $dscb[0] ."";
                                    
                              $result = $db->sql_query($sql_update);
                              if($result)
                              {
                                    $update ++;
                                    $xtpl->assign( 'UP_CB', "<br />" . $lang_module['upd'] . $update . " - ID: " );
                              }
                              else
                              {
                                    $error['csdl'] = $lang_module['csdl'];
                              }
                        }
                    }
                }
                else
                {
                    $error['canthiet'] = $lang_module['canthiet'];
                }
            }
        }
    }
}


//Chen danh sach don vi
if ( $nv_Request->isset_request ( 'im_dv', 'post' ) )
{
    $data = array();  
    if ( $_FILES['dv']['tmp_name'])  
    {  
        $dom = DOMDocument::load( $_FILES['dv']['tmp_name'] );  
        $rows = $dom->getElementsByTagName( 'Row' );  
    	$tde = array();
    	foreach ( $rows as $row)
    	{ 
        	$cells = $row->getElementsByTagName( 'Cell' );  
    		$datarow = array();  
    		foreach ( $cells as $cell )
    		{  
    	   		if ( $line == 0 )
    	   		{
    	      		$tde[] = $cell->nodeValue;
    	   		}
    	   		else
    	   		{
    	   			$datarow [] = $cell->nodeValue;
    	   		} 
    	 	}  
    		$data [] = $datarow;  
    		$line = $line + 1;      
    	}
    
    	foreach( $data as $row ) 
    	{  
    		$dscb = array();
    		$i = 0;
    		if (isset( $row[0] ) )
    		{
        		foreach( $row as $item ) 
        		{
        			$dscb[$i] = $item;
        			$i = $i + 1;	
        		} 
        
                if(!empty($dscb[0]) && !empty($dscb[1]))
                {
                    //Xac dinh don vi da co hay chua
                    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` WHERE `madvi` = " . $dscb[0] . "";
                    $result = $db->sql_query( $sql );
                    $num = $db->sql_numrows($result);
                    
                    //ma don vi phai la so
                    if(!is_numeric($dscb[0]))
                    {
                        $error['e_dv'] = "<b>[" . $dscb[1] . "]</b> " . $lang_module['e_dv'];
                    }
                    
                    if(empty($dscb[2]))
                    {
                        $dscb[2] = "";
                    }
                    if(empty($error))
                    {
                        if(!$num)
                        {
                            $sql_insert = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` (`madvi`, `tendonvi`, `gt_dv`) 
                                    VALUES(
                            		" . $dscb[0] . ", 
                            		" . $db->dbescape( $dscb[1] ) . ",
                                    " . $db->dbescape( $dscb[2] ) . "
                                    )";
                                    
                              $result = $db->sql_query($sql_insert);
                              if($result)
                              {
                                    $insert ++;
                                    $xtpl->assign( 'IM_DV', $lang_module['ins'] . $insert . "      ");
                              }
                              else
                              {
                                    $error['csdl'] = $lang_module['csdl'];
                              }
                        }
                        else
                        {
                            $sql_update = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` SET
                                    `madvi` = " . $dscb[0] . ",
                                    `tendonvi` = " . $db->dbescape( $dscb[1] ) . ",
                                    `gt_dv` = " . $db->dbescape( $dscb[2] ) . "
                                    WHERE `madvi` = " . $dscb[0] ."";
                                    
                              $result = $db->sql_query($sql_update);
                              if($result)
                              {
                                    $update ++;
                                    $xtpl->assign( 'UP_DV', $lang_module['upd'] . $update );
                              }
                              else
                              {
                                    $error['csdl'] = $lang_module['csdl'];
                              }
                        }
                    }
                }
            }
        }
    }
}


//Chen danh sach chuc vu
if ( $nv_Request->isset_request ( 'im_cv', 'post' ) )
{
    $data = array();  
    if ( $_FILES['cv']['tmp_name'])  
    {  
        $dom = DOMDocument::load( $_FILES['cv']['tmp_name'] );  
        $rows = $dom->getElementsByTagName( 'Row' );  
    	$tde = array();
    	foreach ( $rows as $row)
    	{ 
        	$cells = $row->getElementsByTagName( 'Cell' );  
    		$datarow = array();  
    		foreach ( $cells as $cell )
    		{  
    	   		if ( $line == 0 )
    	   		{
    	      		$tde[] = $cell->nodeValue;
    	   		}
    	   		else
    	   		{
    	   			$datarow [] = $cell->nodeValue;
    	   		} 
    	 	}  
    		$data [] = $datarow;  
    		$line = $line + 1;      
    	}
    
    	foreach( $data as $row ) 
    	{  
    		$dscb = array();
    		$i = 0;
    		if (isset( $row[0] ) )
    		{
        		foreach( $row as $item ) 
        		{
        			$dscb[$i] = $item;
        			$i = $i + 1;	
        		} 
        
                if(!empty($dscb[0]) && !empty($dscb[1]))
                {
                    //Xac dinh don vi da co hay chua
                    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` WHERE `macvu` = " . $dscb[0] . "";
                    $result = $db->sql_query( $sql );
                    $num = $db->sql_numrows($result);
                    
                    //ma chuc vu phai la so
                    if(!is_numeric($dscb[0]))
                    {
                        $error['e_cv'] = "<b>[" . $dscb[1] . "]</b> " . $lang_module['e_cv'];
                    }
                    
                    //ma  don vi ko bo trong
                    if(empty($dscb[0]))
                    {
                        $error['em_dv'] = "ID: [" . $dscb[0] . "] " . $lang_module['em_dv'];
                    }
                    
                    if(empty($dscb[2]))
                    {
                        $dscb[2] = "";
                    }
                    if(empty($error))
                    {
                        if(!$num)
                        {
                            if($dscb[2] == "")
                            {
                                $dscb[2] = "&nbsp;";
                            }
                            $sql_insert = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` (`macvu`, `tenchucvu`, `gt_cv`) 
                                    VALUES(
                            		" . $dscb[0] . ", 
                            		" . $db->dbescape( $dscb[1] ) . ",
                                    " . $db->dbescape( $dscb[2] ) . "
                                    )";
                                    
                              $result = $db->sql_query($sql_insert);
                              if($result)
                              {
                                    $insert ++;
                                    $xtpl->assign( 'IM_CV', $lang_module['ins'] . $insert . "      ");
                              }
                              else
                              {
                                    $error['csdl'] = $lang_module['csdl'];
                              }
                        }
                        else
                        {        
                            $sql_update = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` SET
                                    `macvu` = " . $dscb[0] . ",
                                    `tenchucvu` = " . $db->dbescape( $dscb[1] ) . ",
                                    `gt_cv` = " . $db->dbescape( $dscb[2] ) . "
                                    WHERE `macvu` = " . $dscb[0] ."";
                                    
                              $result = $db->sql_query($sql_update);
                              if($result)
                              {
                                    $update ++;
                                    $xtpl->assign( 'UP_CV', $lang_module['upd'] . $update );
                              }
                              else
                              {
                                    $error['csdl'] = $lang_module['csdl'];
                              }
                        }
                    }
                }
            }
        }
    }
}


$url_del = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=import";
$xtpl->assign( 'DEL', $url_del );

//Dem so ban ghi cua danh sach can bo
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "`";
$result = $db->sql_query( $sql );
$num_row = $db->sql_numrows($result);
$xtpl->assign( 'COUNT_CB', $lang_module['count_fe'] . $num_row );

//Dem so ban ghi cua don vi
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi`";
$result = $db->sql_query( $sql );
$num_row = $db->sql_numrows($result);
$xtpl->assign( 'COUNT_DV', $lang_module['count_fe'] . $num_row );

//Dem so ban ghi chucvu
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu`";
$result = $db->sql_query( $sql );
$num_row = $db->sql_numrows($result);
$xtpl->assign( 'COUNT_CV', $lang_module['count_fe'] . $num_row );

if ( $nv_Request->isset_request ( 'ds', 'get' ) )
{
    $ds = filter_text_input ('ds', 'get','');
    if($ds == 'dv')
    {
        mysql_query("DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi`");
        header('Location:'.NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=import"); 
    }
    elseif($ds == 'cv')
    {
        mysql_query("DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu`");
        header('Location:'.NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=import");
    }
    else
    {
        mysql_query("DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "`");
        header('Location:'.NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=import");
    }
}

foreach($error as $errors)
{
    $xtpl->assign( 'ERROR', $errors );
    $xtpl->parse( 'main.loop' );
}
foreach($idok_ins as $ok)
{
    $xtpl->assign( 'SUSS_INS', $ok );
    $xtpl->parse( 'main.ins' );
}
foreach($idok_upd as $ok)
{
    $xtpl->assign( 'SUSS_UPD', $ok );
    $xtpl->parse( 'main.upd' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>