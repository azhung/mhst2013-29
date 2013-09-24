<?php

/*
 * @Project: Quan Ly Doan Vien
 * @Author MHST2013-29
 * @Copyright 2013
 * @Createdate 19/7/2013
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['edit_dv'];

$xtpl = new XTemplate( "donvi_edit.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );

$error = "";

$madvi = $nv_Request->get_int ('madvi', 'get','');

   $donvi = array();
   $result = $db->sql_query( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` WHERE `madvi`= ".$madvi."");
   while ( list ( $madvi, $tendvi, $gt_dv ) = $db->sql_fetchrow($result) )
   {
      $donvi[] = array (
         "madvi" => $madvi,
         "tendvi" => $tendvi,
         "gt_dv" => $gt_dv
      );
   }

if ( $nv_Request->isset_request( 'confirm', 'post' ) )
{
    $madvi = $nv_Request->get_int ('madvi1', 'post','');
    $tendvi = filter_text_input ('tendvi1', 'post','');
    $gt_dv = filter_text_input ('gt_dv1', 'post','');
    
    if(isset($madvi))
    {
        if(empty($tendvi))
        {
            $error = $lang_module['error_tdv'];    
        }
        else
        {
            $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` SET `tendonvi` = " . $db->dbescape($tendvi) . ",
            `gt_dv` = " . $db->dbescape($gt_dv) . " WHERE `madvi` = " . $madvi . "";
            $result = $db->sql_query($sql);
                                      
            if(!$result)
            {
                $error = $lang_module['error_csdl'] . $sql;   
            }
            else
            {
                Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=donvi");
            }
        }
    }
}

$ac = filter_text_input ('ac', 'get','');
$madvi = $nv_Request->get_int ('madvi', 'get','');

if($ac == 'del')
{
    $check = "SELECT id FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE madvi = " . $madvi;
    $result = $db->sql_query($check);
    $num = $db->sql_numRows($result);
    
    if($num != 0)
    { 
        Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
    }
    else
    {
        $result = $db->sql_query("DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` WHERE `madvi` = ".$madvi."" );
        Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=donvi");
    }
}

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&madvi=" . $madvi;
$xtpl->assign( 'ACTION', $url );

foreach ($donvi AS $dv)
{
    $xtpl->assign( 'DV', $dv);
}

$xtpl->assign( 'ERROR', $error );


$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>