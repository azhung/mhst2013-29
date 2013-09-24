<?php

/**
 * @Project NUKEVIET 3.4
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Copyright (C) 2012 by hongoctrien
 * @Createdate July 05, 2012 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['config'];

$xtpl = new XTemplate( "config.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

$config = array();
$result = $db->sql_query( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_config`");
while ( list ( $toplip, $search, $per_page ) = $db->sql_fetchrow($result) )
{
   $config[] = array (
      "toplip" => $toplip,
      "search" => $search,
      "per_page" => $per_page
   );
   
   $xtpl->assign( 'CHECK', $toplip == 1 ? " checked=\"checked\"" : "" );
   $xtpl->assign( 'CHECK_S', $search == 1 ? " checked=\"checked\"" : "" );
}

if ( $nv_Request->isset_request( 'config', 'post' ) )
{
    $toplip = $nv_Request->get_int ('toplip', 'post','');
    $per_page = $nv_Request->get_int ('per_page', 'post','');
    $search = $nv_Request->get_int ('search', 'post','');
    
    $result = $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_config`
                                SET `toplip` = " . $toplip . ",
                                `search` = " . $search . ",
                                `per_page` = " . $per_page . "
                                ");
    if(!$result)
    {
        $error = $lang_module['error_csdl'] ."<br />". mysql_error();   
    }
    else
    {
        Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=config");
    }
    $xtpl->assign( 'ERROR', $error );
}

foreach ($config as $conf)
{
    $xtpl->assign( 'CONF', $conf );
}

if( defined( 'NV_EDITOR' ) )
{
	require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );
}
$content_file = NV_ROOTDIR . '/' . NV_DATADIR . '/' . NV_LANG_DATA . '_' . $module_data . 'Content.txt';

if( $nv_Request->get_int( 'save', 'post' ) == '1' )
{
	$bodytext = nv_editor_filter_textarea( 'bodytext', '', NV_ALLOWED_HTML_TAGS, true );
	file_put_contents( $content_file, $bodytext );

	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );
	die();
}

$bodytext = "";
if( file_exists( $content_file ) )
{
	$bodytext = file_get_contents( $content_file );
	$bodytext = nv_editor_br2nl( $bodytext );
}

$is_edit = $nv_Request->get_int( 'is_edit', 'get', 0 );
if( empty( $bodytext ) ) $is_edit = 1;

if( $is_edit )
{
	if( ! empty( $bodytext ) ) $bodytext = nv_htmlspecialchars( $bodytext );
	
	$xtpl->assign( 'FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op );
	
	if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
	{
		$data = nv_aleditor( "bodytext", '99%', '300px', $bodytext );
	}
	else
	{
		$data = "<textarea style=\"width: 99%\" name=\"bodytext\" id=\"bodytext\" cols=\"20\" rows=\"8\">" . $bodytext . "</textarea>";
	}
	
	$xtpl->assign( 'DATA', $data );
	
	$xtpl->parse( 'main.edit' );
}
else
{	
	$xtpl->assign( 'DATA', $bodytext );
	$xtpl->assign( 'URL_EDIT', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;is_edit=1" );
	
	$xtpl->parse( 'main.data' );
}

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "";
$xtpl->assign( 'ACTION', $url );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>