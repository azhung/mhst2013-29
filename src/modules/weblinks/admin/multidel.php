<?php

/**
 * @Project NUKEVIET 3.4
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 - 2012 VINADES.,JSC. All rights reserved
 * @Createdate Thu, 25 Oct 2012 00:00:00 GMT
 */

if(!defined('NV_IS_FILE_ADMIN'))die('Stop!!!');$id=$nv_Request->get_array('idcheck','post');$msg="";$sizeof=sizeof($id);for($i=0;$i<$sizeof;++$i){$sql="DELETE FROM `".NV_PREFIXLANG."_".$module_data."_rows` WHERE `id`=".intval($id[$i]);if($db->sql_query($sql)){$db->sql_freeresult();$msg.=$lang_module['weblink_del_success'];}else{$msg.=$lang_module['weblink_del_error'];}}include(NV_ROOTDIR."/includes/header.php");echo nv_admin_theme($msg);include(NV_ROOTDIR."/includes/footer.php");

?>