<?php

/*
 * @Project: Quan Ly Doan Vien
 * @Author MHST2013-29
 * @Copyright 2013
 * @Createdate 19/7/2013
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['edit_cb'];

$xtpl = new XTemplate( "cbdoan_edit.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );

$op = filter_text_input ('op', 'get','');
$id = filter_text_input ('id', 'get','');
$ac = filter_text_input ('ac', 'get','');

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&amp;id=" . $id;
$xtpl->assign( 'ACTION', $url );

if($ac == 'del')
{
    $result = $db->sql_query("DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id` = '".$id."' ");
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "");
}

$error = array();
$cbdoan = array();

if(isset($id))
{
   $cbdoan = array();
   $result = $db->sql_query( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`= " . $id . "");
   while ( list ( $id, $ten, $ngsinh, $gtinh, $avt, $nvdoan, $dang, $nvdang, $quequan, $diachi, $madvi, $macvu1, $macvu2, $macvu3, $email, $lienchi, $kyluat, $doanphi, $web, $nhanxet )
                  = $db->sql_fetchrow($result) )
   {
      $cbdoan[] = array (
         "id" => $id,
         "ten" => $ten,
         "ngsinh" => $ngsinh,
         "gt" => $gtinh,
         "avt" => $avt,
         "nvdoan" => $nvdoan,
         "dang" => $dang,
         "nvdang" => $nvdang,
         "que" => $quequan,
         "diachi" => $diachi,
         "madvi" => $madvi,
         "macvu1" => $macvu1,
         "macvu2" => $macvu2,
         "macvu3" => $macvu3,
         "email" => $email,
         "lienchi" => $lienchi,
         "kyluat" => $kyluat,
         "doanphi" => $doanphi,
         "web" => $web,
         "nhanxet" => $nhanxet
      );
      
      if($gtinh != 0)
      {
        $xtpl->assign( 'CHECK_GT', 'checked="checked"' );
      }
      
      if($dang != 0)
      {
        $xtpl->assign( 'CHECK_D', 'checked="checked"' );
      }
    }    
}

//Cap nhat du lieu tu form
$cb_doan = array();
if ( $nv_Request->isset_request( 'confirm', 'post' ) )
{
    //dua thong tin tu form vao mang
    $cb_doan['id'] = filter_text_input ('id', 'post','');
    $cb_doan['ten'] = filter_text_input ('ten', 'post','');
    $cb_doan['ngsinh'] = filter_text_input ('ngsinh', 'post','');
    $cb_doan['gt'] = $nv_Request->get_int ('gt', 'post','');    
    $cb_doan['avt'] = filter_text_input ('avt', 'post','');
    $cb_doan['nvdoan'] = filter_text_input ('nvdoan', 'post','');    
    $cb_doan['dang'] = $nv_Request->get_int ('dang', 'post','');
    $cb_doan['nvdang'] = filter_text_input ('nvdang', 'post','');    
    $cb_doan['que'] = filter_text_input ('que', 'post','');
    $cb_doan['diachi'] = filter_text_input ('diachi', 'post','');
    $cb_doan['madvi'] = $nv_Request->get_int ('madvi', 'post','');
    $cb_doan['macvu1'] = $nv_Request->get_int ('macvu1', 'post','');
    $cb_doan['macvu2'] = $nv_Request->get_int ('macvu2', 'post','');
    $cb_doan['macvu3'] = $nv_Request->get_int ('macvu3', 'post','');
    $cb_doan['email'] = filter_text_input ('email', 'post','');
    $cb_doan['lienchi'] = filter_text_input ('lienchi', 'post','');
    $cb_doan['kyluat'] = filter_text_input ('kyluat', 'post','');
    $cb_doan['doanphi'] = filter_text_input ('doanphi', 'post','');
    $cb_doan['web'] = filter_text_input ('web', 'post','');
    $cb_doan['nhanxet'] = filter_text_textarea( 'nhanxet', '', NV_ALLOWED_HTML_TAGS );
    
    //Dinh dang dia chi web
    if ( ! empty( $cb_doan['web'] ) )
    {
        if ( ! preg_match( "#^(http|https|ftp|gopher)\:\/\/#", $cb_doan['web'] ) )
        {
            $cb_doan['web'] = "http://" . $cb_doan['web'];
        }
        if ( ! nv_is_url( $cb_doan['web'] ) )
        {
            $cb_doan['web'] = "";
        }
    }
    
    if(empty($cb_doan['avt']))
    {
        $cb_doan['avt'] = NV_BASE_SITEURL . "images/nophoto.png";
    }
    
foreach ($cb_doan AS $cb)
{
    $xtpl->assign( 'CBDOAN', $cb);
}
    
    //Xu ly cac ky tu xuong dong trong textarea
    $cb_doan['tt'] = nv_nl2br( $cb_doan['tt'], "<br />" );
    
    //Kiem tra loi
    //Check loi ten can bo
    if(empty($cb_doan['ten']))
    {
        $error['no_name'] = $lang_module['no_name'];
    }
    
    //Check loi ngay sinh
    if(empty($cb_doan['ngsinh']))
    {
        $error['no_ngsinh'] = $lang_module['no_ngsinh'];
    }
    elseif(strlen($cb_doan['ngsinh']) != 10 )
    {
        $error['format_ngsinh'] = $lang_module['format_ngsinh'];
    }
    
    //Check loi ngay vao doan
    if(!empty($cb_doan['nvdoan']) && strlen($cb_doan['nvdoan']) != 10 )
    {
        $error['format_nvdoan'] = $lang_module['format_nvdoan'];
    }
    
    //Check loi ngay vao dang
    if($cb_doan['dang'] == 0 && !empty($cb_doan['nvdang']))
    {
        $error['no_dang'] = $lang_module['no_dang'];
    }
    if( $cb_doan['dang'] == 1 && !empty($cb_doan['nvdang']) && strlen($cb_doan['nvdang']) != 10 )
    {
        $error['format_nvdang'] = $lang_module['format_nvdang'];
    }
    
    //Check loi don vi
    if($cb_doan['madvi'] == "")
    {
        $error['no_dvi'] = $lang_module['no_dvi'];
    }
    
    //Check loi chuc vu
    if($cb_doan['macvu1'] == "")
    {
        $error['no_cvu'] = $lang_module['no_cvu'];
    }
    elseif($cb_doan['macvu1'] == $cb_doan['macvu2'] OR $cb_doan['macvu1'] == $cb_doan['macvu3'] OR !empty($cb_doan['macvu2']) && !empty($cb_doan['macvu3']) 
    && $cb_doan['macvu2'] == $cb_doan['macvu3'])
    {
        $error['tr_cvu'] = $lang_module['tr_cvu'];
    }
    
    //Kiem tra dinh dang email
    $pattern = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
    $mailStr = $cb_doan['email'];
    if(( !empty($cb_doan['email']) && preg_match($pattern, $mailStr)==0) ) 
    {
        $error['format_email'] = $lang_module['format_email'];
    }
    

    if(empty($error))
    {
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "` SET
            `hoten` = " . $db->dbescape( $cb_doan['ten'] ) . ",
            `ngsinh` = " . $db->dbescape( $cb_doan['ngsinh'] ) . ",
            `gtinh` = " . $cb_doan['gt'] . ",
            `avt` = " . $db->dbescape( $cb_doan['avt'] ) . ",
            `nvdoan` = " . $db->dbescape( $cb_doan['nvdoan'] ) . ",            
            `dang` = " . $cb_doan['dang'] . ",
            `nvdang` = " . $db->dbescape( $cb_doan['nvdang'] ) . ",            
            `quequan` = " . $db->dbescape( $cb_doan['que'] ) . ",
            `diachi` = " . $db->dbescape( $cb_doan['diachi'] ) . ",
            `madvi` = " . $cb_doan['madvi'] . ",
            `macvu1` = " . $cb_doan['macvu1'] . ",
            `macvu2` = " . $cb_doan['macvu2'] . ",
            `macvu3` = " . $cb_doan['macvu3'] . ",
            `email` = " . $db->dbescape( $cb_doan['email'] ) . ",
            `lienchi` = " . $db->dbescape( $cb_doan['lienchi'] ) . ",
            `kyluat` = " . $db->dbescape( $cb_doan['kyluat'] ) . ",
            `doanphi` = " . $db->dbescape( $cb_doan['doanphi'] ) . ",
            `website` = " . $db->dbescape( $cb_doan['web'] ) . ",
            `nhanxet` = " . $db->dbescape( $cb_doan['nhanxet'] ) . " WHERE `id` = ".$cb_doan['id']."";
            
    $result = $db->sql_query($sql);
    
    if($result)
    {
        Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "");
    }
    }
}


//Lay danh sach cac don vi
$donvi = getDonvi();
foreach($donvi as $list_dv)
{
    foreach ($cbdoan as $cb)
    {
        $select = ( $list_dv['madvi'] == $cb['madvi'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign('LIST_DV', $list_dv);
        $xtpl->assign('SELECT', $select);
        $xtpl->parse( 'main.dv' );
    }
}

//Lay danh sach chuc vu
$chucvu = getChucvu();
foreach($chucvu as $list_cv)
{
    foreach($cbdoan as $cb)
    {
        $select1 = ( $list_cv['macvu'] == $cb['macvu1'] ) ? "selected=\"selected\"" : "";
        $select2 = ( $list_cv['macvu'] == $cb['macvu2'] ) ? "selected=\"selected\"" : "";
        $select3 = ( $list_cv['macvu'] == $cb['macvu3'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign('LIST_CV', $list_cv);
        $xtpl->assign('SELECT1', $select1);
        $xtpl->assign('SELECT2', $select2);
        $xtpl->assign('SELECT3', $select3);
        $xtpl->parse( 'main.cv1' );
        $xtpl->parse( 'main.cv2' );
        $xtpl->parse( 'main.cv3' );
    }
}

foreach ($cbdoan AS $cb)
{
    $xtpl->assign( 'CBDOAN', $cb);
}

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