<?php
/**
 * @Project Quan Ly Doan Vien
 * @Author MHST2013-29
 * @copyright 2013
 * @createdate 19/7/2013 10:10 AM
 */
if(!defined('NV_IS_ADMIN_QL')) { die('Stop!!!'); }

$result = false;
$id = $nv_Request->get_int('id', 'post,get', 0);

if( $id > 0 )
{
	//$sql = "DELETE FROM `nv3_vi_dmc_khoahoc` WHERE `kh_id` = ". $id;
   	$sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data ."_chidoan` WHERE `cd_id`=" . $id;
   	$result = $db->sql_query( $sql );
		
}

if( $result )
{
   echo $lang_module['del_success'];
}
else
{
   echo $lang_module['del_error'];
}
?>