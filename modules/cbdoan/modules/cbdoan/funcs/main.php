<?php

/**
 * @Project NUKEVIET 3.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_MOD_CBDOAN' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];

$xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );

$notice = "";
$thongke = "";
$key = "";

//Lay danh sach cac don vi
$madvi = $nv_Request->get_int( 'madvi', 'post,get', '' );
$dv = 0;
$donvi = getDonvi();
foreach($donvi as $list_dv)
{
    $xtpl->assign('LIST_DV', $list_dv);
    $xtpl->assign('SELECT', $list_dv['madvi'] == $madvi ? "selected=\"selected\"" : "");
    //dem so luong don vi hien co
    $dv ++;
    $xtpl->parse( 'main.dv' );
}

//Lay thong tin cau hinh gan cho cac bien tuong ung
$conf = $db->sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_config`");
list($toplip, $search, $per_page) = $db->sql_fetchrow($conf);

$page = $nv_Request->get_int('page', 'get', 0 );

//Bat tat tim kiem
if( $search == 1 )
{
    if ( $nv_Request->isset_request( 'sub_search', 'post' ) )
    {
        $key = filter_text_input ('key', 'post','');
    }
    else
    {
        $key = filter_text_input ('key', 'get','');
    }
    if($page == 0)
    {
        $xtpl->parse( 'main.search' );
    }
}

if($madvi == 0)
{
    $sql = "FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE 1=1 AND hoten like '%" . $key . "%'";
    $base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;        
}
else
{
    $sql = "FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE madvi = " . $madvi . "";
    $base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;madvi=" . $madvi;        
}

if($key != "")
{
    $base_url = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" 
                . NV_NAME_VARIABLE . "=" . $module_name . "&amp;key=" . $key . "";
}

$sql1 = "SELECT COUNT(*) " . $sql;
$result1 = $db->sql_query( $sql1 ); 

list( $all_page ) = $db->sql_fetchrow( $result1 );

if($madvi == 0)
{
    $sql2 = "SELECT cb.id, cb.hoten, cb.ngsinh, cb.gtinh, cb.avt, cb.diachi, cb.email, dv.tendonvi, cv.tenchucvu FROM `" 
       . NV_PREFIXLANG . "_" . $module_data .
       "` CB INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` DV
       INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV                  
       ON CB.madvi = DV.madvi AND CB.macvu1 = CV.macvu WHERE 1 = 1 AND cb.hoten like '%" . $key . "%' LIMIT " . $page . ", " . $per_page . "";
}
else
{
    $sql2 = "SELECT cb.id, cb.hoten, cb.ngsinh, cb.gtinh, cb.avt, cb.diachi, cb.email, dv.tendonvi, cv.tenchucvu FROM `" 
       . NV_PREFIXLANG . "_" . $module_data .
       "` CB INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` DV
       INNER JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV                  
       ON CB.madvi = DV.madvi AND CB.macvu1 = CV.macvu WHERE cb.madvi = " . $madvi . " LIMIT " . $page . ", " . $per_page;
}

$query2 = $db->sql_query( $sql2 );
$data = array();

while ( list( $id, $hoten, $ngsinh, $gtinh, $avt, $diachi, $email, $tendonvi, $tenchucvu ) = $db->sql_fetchrow( $query2 ) )
{
        $gtinh == 1 ? $gtinh = $lang_module['female'] : $gtinh = $lang_module['male'];
        
        $data[] = array(
        "id" => $id,
        "hoten" => $hoten,
        "ngsinh" => $ngsinh,
        "gtinh" => $gtinh,
        "avt" => $avt,
        "diachi" => $diachi,
        "email" => $email,
        "tendonvi" => $tendonvi,
        "tenchucvu" => $tenchucvu
        );
    
    if($madvi != 0)
    {
        $notice = $lang_module['notice_donvi'] . "\"" .$tendonvi . "\"";
        $thongke = sprintf($lang_module['thongke_dv'], $all_page, $tendonvi);
    }    
    else
    {        
        if($key == "")
        {
            $f = 0;
            $thongke = sprintf($lang_module['thongke'], $all_page, $dv);
            //Lay noi dung thong bao
            $bodytext = "";
            $content_file = NV_ROOTDIR . '/' . NV_DATADIR . '/' . NV_LANG_DATA . '_' . $module_data . 'Content.txt';
            if( file_exists( $content_file ) )
            {
            	$bodytext = file_get_contents( $content_file );
            }
            $xtpl->assign('BODYTEXT', $bodytext);
        }
        else
        {
            $notice = sprintf($lang_module['searchok'], $all_page, $key);
            //echo $key; exit();
        }
    }
}
if(empty($data))
{
    $notice = $lang_module['no_search'];
}

$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
$xtpl->assign( 'PAGE', $generate_page );

$sql = "SELECT tendonvi, gt_dv FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` WHERE madvi = " . $madvi;
$result = $db->sql_query($sql);
while( $row = $db->sql_fetchrow($result))
{
    $xtpl->assign('GT_DV', $row['gt_dv']);
    if($all_page == 0)
    {
        $notice = $lang_module['no_cb'] . "\"" .$row['tendonvi'] . "\"";
    }
}

foreach( $data AS $cbdoan )
{   
    $xtpl->assign('CBDOAN', $cbdoan);
    
	if($global_config['is_url_rewrite']==1)
	{
		$xtpl->assign( 'DETAIL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "/" . $cbdoan['id']."-".change_alias($cbdoan['hoten']));
    }
	else 
	{
		$xtpl->assign( 'DETAIL', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name  . "&amp;" . NV_OP_VARIABLE . "=detail/" . $cbdoan['id']."-".change_alias($cbdoan['hoten']));
    }	
            
    //Bat tat dia chi tai toplip
    if(!empty($cbdoan['diachi']))
    {
        $xtpl->parse( 'main.table.loop.toplip.diachi' );
    }
    
    //Bat tat toplip
    if( $toplip == 1 )
    {
        $xtpl->parse( 'main.table.loop.toplip' );
    }
    
    //Vong lap
    $xtpl->parse( 'main.table.loop' );        
}

if($all_page > 0)
{
    $xtpl->parse( 'main.table' );
}

$xtpl->assign('NOTICE', $notice);  
$xtpl->assign('THONGKE', $thongke);
$xtpl->assign( 'ACTION', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>