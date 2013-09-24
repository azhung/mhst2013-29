<?php

/**
 * @Project NUKEVIET 3.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['add_chucvu'];

$xtpl = new XTemplate( "chucvu_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "";
$xtpl->assign( 'ACTION', $url );

$chucvu = array();
$error = "";

if ( $nv_Request->isset_request( 'confirm', 'post' ) )
{
    $chucvu['tencvu'] = filter_text_input ('tenchucvu', 'post','');
    $chucvu['gt_cv'] = filter_text_input ('gt_cv', 'post','');
    
    //Xu ly cac ky tu xuong dong trong textarea
    $chucvu['gt_cv'] = nv_nl2br( $chucvu['gt_cv'], "<br />" );
    
    if (empty($chucvu['tencvu']))
    {
        $error = $lang_module['error_tcv'];
    }
    else
    {
        $result = $db->sql_query("INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` 
                                  VALUES ( NULL, " . $db->dbescape($chucvu['tencvu']) . ", " . $db->dbescape($chucvu['gt_cv']) . " )");
        
        if(!$result)
        {
            $error = $lang_module['error_csdl'];   
        }
        else
        {
            Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=chucvu");
        }
    }
    $xtpl->assign( 'CHUCVU', $chucvu );
}

$xtpl->assign( 'ERROR', $error );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>