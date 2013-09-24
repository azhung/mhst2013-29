<?php

/**
 * @Project NUKEVIET 3.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['edit_cv'];

$xtpl = new XTemplate( "chucvu_edit.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );

$macvu = $nv_Request->get_int ('macvu', 'get','');

   $chucvu = array();
   $result = $db->sql_query( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` WHERE `macvu` = " . $macvu . "");
   while ( list ( $macvu, $tenchucvu, $gt_cv ) = $db->sql_fetchrow($result) )
   {
      $chucvu[] = array (
         "macvu" => $macvu,
         "tenchucvu" => $tenchucvu,
         "gt_cv" => $gt_cv
      );
   }

if ( $nv_Request->isset_request( 'confirm', 'post' ) )
{
    $macvu = $nv_Request->get_int ('macvu1', 'post','');
    $tenchucvu = filter_text_input ('tenchucvu1', 'post','');
    $gt_cv = filter_text_input ('gt_cv1', 'post','');
    
    if(isset($macvu))
    {
        if(empty($tenchucvu))
        {
            $error = $lang_module['error_tcv'];    
        }
        else
        {
            $result = $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu`
                                      SET `tenchucvu` = " . $db->dbescape($tenchucvu) . ",
                                      `gt_cv` = " . $db->dbescape($gt_cv) . "
                                      WHERE `macvu` = " . $macvu . "");
                                      
            if(!$result)
            {
                $error = $lang_module['error_csdl'] . mysql_error();   
            }
            else
            {
                Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=chucvu");
            }
        }
    $xtpl->assign( 'ERROR', $error );
    }
}

$macvu = $nv_Request->get_int ('macvu', 'get','');
$ac = filter_text_input ('ac', 'get','');
if($ac == 'del')
{
    $check = "SELECT id FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE macvu1 = " . $macvu . " OR macvu2 = " . $macvu . " OR macvu3 = " . $macvu;
    $result = $db->sql_query($check);
    $num = $db->sql_numRows($result);
    
    if($num != 0)
    { 
        Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
    }
    else
    {
    $result = $db->sql_query("DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` WHERE `macvu` = ".$macvu." ");
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=chucvu");
    }
}

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&macvu=" . $macvu;
$xtpl->assign( 'ACTION', $url );

foreach ($chucvu AS $cv)
{
    $xtpl->assign( 'CV', $cv);
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>