<?php

/**
 * @Project NUKEVIET 3.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['cbdoan_add'];
global $global_config, $file_name;

$xtpl = new XTemplate( "cbdoan_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "";
$xtpl->assign( 'ACTION', $url );

$op = filter_text_input ('op', 'get','');
$donvi = getDonvi();
$chucvu = getChucvu();

if(empty($donvi))
{
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=donvi_add");
}
elseif(empty($chucvu))
{
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=chucvu_add");
}

$cbdoan = array();
$error = array();

if ( $nv_Request->isset_request( 'confirm', 'post' ) )
{
    //dua thong tin tu form vao mang
    $cbdoan['ten'] = filter_text_input ('ten', 'post','');
    $cbdoan['ngsinh'] = filter_text_input ('ngsinh', 'post','');
    $cbdoan['gt'] = $nv_Request->get_int ('gt', 'post','');    
    $cbdoan['avt'] = filter_text_input ('avt', 'post','');
    $cbdoan['nvdoan'] = filter_text_input ('nvdoan', 'post','');    
    $cbdoan['dang'] = $nv_Request->get_int ('dang', 'post','');
    $cbdoan['nvdang'] = filter_text_input ('nvdang', 'post','');    
    $cbdoan['que'] = filter_text_input ('que', 'post','');
    $cbdoan['diachi'] = filter_text_input ('diachi', 'post','');
    $cbdoan['madvi'] = $nv_Request->get_int ('madvi', 'post','');
    $cbdoan['macvu1'] = $nv_Request->get_int ('macvu1', 'post','');
    $cbdoan['macvu2'] = $nv_Request->get_int ('macvu2', 'post','');
    $cbdoan['macvu3'] = $nv_Request->get_int ('macvu3', 'post','');
    $cbdoan['email'] = filter_text_input ('email', 'post','');
    $cbdoan['lienchi'] = filter_text_input ('lienchi', 'post','');
    $cbdoan['kyluat'] = filter_text_input ('kyluat', 'post','');
    $cbdoan['doanphi'] = filter_text_input ('doanphi', 'post','');
    $cbdoan['web'] = filter_text_input ('web', 'post','');
    $cbdoan['nhanxet'] = filter_text_textarea( 'nhanxet', '', NV_ALLOWED_HTML_TAGS );
    
    //Dinh dang dia chi web
    if ( ! empty( $cbdoan['web'] ) )
    {
        if ( ! preg_match( "#^(http|https|ftp|gopher)\:\/\/#", $cbdoan['web'] ) )
        {
            $cbdoan['web'] = "http://" . $cbdoan['web'];
        }
        if ( ! nv_is_url( $cbdoan['web'] ) )
        {
            $cbdoan['web'] = "";
        }
    }
    
    if(empty($cbdoan['avt']))
    {
        $cbdoan['avt'] = NV_BASE_SITEURL . "images/nophoto.png";
    }
    
    //Xu ly cac ky tu xuong dong trong textarea
    $cbdoan['tt'] = nv_nl2br( $cbdoan['tt'], "<br />" );

    //Kiem tra loi
    //Check loi ten can bo
    if(empty($cbdoan['ten']))
    {
        $error['no_name'] = $lang_module['no_name'];
    }
    
    //Check loi ngay sinh
    if(empty($cbdoan['ngsinh']))
    {
        $error['no_ngsinh'] = $lang_module['no_ngsinh'];
    }
    elseif(strlen($cbdoan['ngsinh']) != 10 )
    {
        $error['format_ngsinh'] = $lang_module['format_ngsinh'];
    }
    
    //Check loi ngay vao doan
    if(!empty($cbdoan['nvdoan']) && strlen($cbdoan['nvdoan']) != 10 )
    {
        $error['format_nvdoan'] = $lang_module['format_nvdoan'];
    }
    
    //Check loi ngay vao dang
    if($cbdoan['dang'] == 0 && !empty($cbdoan['nvdang']))
    {
        $error['no_dang'] = $lang_module['no_dang'];
    }
    if( $cbdoan['dang'] == 1 && strlen($cbdoan['nvdang']) != 10 )
    {
        $error['format_nvdang'] = $lang_module['format_nvdang'];
    }
    
    //Check loi don vi
    if($cbdoan['madvi'] == "")
    {
        $error['no_dvi'] = $lang_module['no_dvi'];
    }
    
    //Check loi chuc vu
    if($cbdoan['macvu1'] == "")
    {
        $error['no_cvu'] = $lang_module['no_cvu'];
    }
    elseif($cbdoan['macvu1'] == $cbdoan['macvu2'] OR $cbdoan['macvu1'] == $cbdoan['macvu3'] OR !empty($cbdoan['macvu2']) && !empty($cbdoan['macvu3']) 
    && $cbdoan['macvu2'] == $cbdoan['macvu3'])
    {
        $error['tr_cvu'] = $lang_module['tr_cvu'];
    }
    
    //Kiem tra dinh dang email
    $pattern = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
    $mailStr = $cbdoan['email'];
    if(( !empty($cbdoan['email']) && preg_match($pattern, $mailStr)==0) ) 
    {
        $error['format_email'] = $lang_module['format_email'];
    }
    

    
///////////////////////////////////////
    if(empty($error))
    {
        $sql = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "` (
            `id`, `hoten`, `ngsinh`, `gtinh`, `avt`, `nvdoan`, `dang`, `nvdang`, `quequan`, `diachi`, `madvi`, `macvu1`, `macvu2`, `macvu3`, `email`, `lienchi`, `kyluat`, `doanphi`, `website`, `nhanxet`) 
            VALUES(
    		NULL, 
    		" . $db->dbescape( $cbdoan['ten'] ) . ",
    		" . $db->dbescape( $cbdoan['ngsinh'] ) . ",
    		" . $cbdoan['gt'] . ",
            " . $db->dbescape( $cbdoan['avt'] ) . ",
            " . $db->dbescape( $cbdoan['nvdoan'] ) . ",            
            " . $cbdoan['dang'] . ",
            " . $db->dbescape( $cbdoan['nvdang'] ) . ",            
            " . $db->dbescape( $cbdoan['que'] ) . ",
            " . $db->dbescape( $cbdoan['diachi'] ) . ",
            " . $cbdoan['madvi'] . ",
            " . $cbdoan['macvu1'] . ",
            " . $cbdoan['macvu2'] . ",
            " . $cbdoan['macvu1'] . ",
            " . $db->dbescape( $cbdoan['email'] ) . ",
            " . $db->dbescape( $cbdoan['lienchi'] ) . ",
            " . $db->dbescape( $cbdoan['kyluat'] ) . ",
            " . $db->dbescape( $cbdoan['doanphi'] ) . ",
            " . $db->dbescape( $cbdoan['web'] ) . ",
            " . $db->dbescape( $cbdoan['nhanxet'] ) . "
    		)";
            
            $kq = $db->sql_query_insert_id( $sql );
            if($kq)
            {
                Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE);
            }
            else
            {
                $error['csdl'] = $lang_module['csdl'] . mysql_error();
            }
    }
}
else
{
    $cbdoan['dang'] = 0;
    $cbdoan['gt'] = 1;
}

$cbdoan['dang1'] = $cbdoan['dang'] ? " checked=\"checked\"" : "";
$cbdoan['gt1'] = $cbdoan['gt'] ? " checked=\"checked\"" : "";

//Lay danh sach cac don vi
foreach($donvi as $list_dv)
{
    $xtpl->assign('LIST_DV', $list_dv);
    $xtpl->parse( 'main.dv' );
}

//Lay danh sach chuc vu
foreach($chucvu as $list_cv)
{
    $xtpl->assign('LIST_CV', $list_cv);
    $xtpl->parse( 'main.cv1' );
    $xtpl->parse( 'main.cv2' );
    $xtpl->parse( 'main.cv3' );
}

$xtpl->assign( 'CBDOAN', $cbdoan );

foreach($error as $errors)
{
    $xtpl->assign( 'ERROR', $errors );
    $xtpl->parse ( 'main.loop' );
}

$xtpl->assign( 'BROWSER', NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=upload&popup=1&area=" + area+"&path="+path+"&type="+type, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no' );
$xtpl->assign( 'PATH', NV_UPLOADS_DIR . '/' . $module_name . "" );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>