<?php
/*
 * @Project: Quan Ly Doan Vien
 * @Author MHST2013-29
 * @Copyright 2013
 * @Createdate 19/7/2013
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['add_donvi'];

$xtpl = new XTemplate( "donvi_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "";
$xtpl->assign( 'ACTION', $url );

$donvi = array();
$error = "";

if ( $nv_Request->isset_request( 'confirm', 'post' ) )
{
    $donvi['tendvi'] = filter_text_input ('tendvi', 'post','');
    $donvi['gt_dv'] = filter_text_input ('gt_dv', 'post','');
    
    //Xu ly cac ky tu xuong dong trong textarea
    $donvi['gt_dv'] = nv_nl2br( $donvi['gt_dv'], "<br />" );

    if (empty($donvi['tendvi']))
    {
        $error = $lang_module['error_tdv'];
    }
    else
    {
        $result = $db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` 
                                  VALUES (NULL, " . $db->dbescape($donvi['tendvi']) . ", " . $db->dbescape($donvi['gt_dv']) . ")");
        
        if(!$result)
        {
            $error = $lang_module['error_csdl'];   
        }
        else
        {
            Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=donvi");
        }
    }
    $xtpl->assign( 'DONVI', $donvi );
}

$xtpl->assign( 'ERROR', $error );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>