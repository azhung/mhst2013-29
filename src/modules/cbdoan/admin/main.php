<?php

/*
 * @Project: Quan Ly Doan Vien
 * @Author MHST2013-29
 * @Copyright 2013
 * @Createdate 19/7/2013
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['dschucvu'];

$xtpl = new XTemplate( "main.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

//Lay danh sach cac don vi
$madvi = $nv_Request->get_int( 'madvi', 'post,get', '' );
$donvi = getDonvi();
foreach($donvi as $list_dv)
{
    $xtpl->assign('LIST_DV', $list_dv);
    $xtpl->assign('SELECT', $list_dv['madvi'] == $madvi ? "selected=\"selected\"" : "");
    $xtpl->parse( 'main.dv' );
}

$sql = "FROM `" . NV_PREFIXLANG . "_" . $module_data . "`";
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name;

$sql1 = "SELECT COUNT(*) " . $sql;
   
$result1 = $db->sql_query( $sql1 );
list( $all_page ) = $db->sql_fetchrow( $result1 );

if($all_page == 0)
{
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cbdoan_add");
}

$page = $nv_Request->get_int( 'page', 'get', 0 );
$per_page = 20;

if($madvi == 0)
{
    $dv = "";
}
else
{
    $dv = "AND cb.madvi=" . $madvi . "";
}
   
$sql2 = "SELECT CB.*, CV.tenchucvu AS CHUCVU1, CV2.tenchucvu AS CHUCVU2, CV3.tenchucvu AS CHUCVU3, DV.tendonvi  FROM `" . NV_PREFIXLANG . "_" . $module_data . "` 
    CB LEFT JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV ON CB.macvu1=CV.macvu LEFT JOIN `" 
    . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV2 ON CB.macvu2=CV2.macvu
    LEFT JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV3 ON CB.macvu3=CV3.macvu
    LEFT JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` DV ON CB.madvi=DV.madvi WHERE 1=1 ".$dv." LIMIT " . $page . ", " . $per_page;

$query2 = $db->sql_query( $sql2 );

while ( $row = $db->sql_fetchrow( $query2 ) )
{
    $xtpl->assign( 'CBDOAN', $row );
    $xtpl->assign( 'EDIT', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cbdoan_edit&ac=edit&id=" .$row['id']);
    $xtpl->assign( 'DEL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cbdoan_edit&ac=del&id=" .$row['id']);
    $xtpl->parse( 'main.loop' );
}

$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );

$xtpl->assign( 'PAGE', $generate_page );
$xtpl->assign( 'ACTION', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>