<?php

/**
 * @Project NUKEVIET 3.4
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 - 2012 VINADES.,JSC. All rights reserved
 * @Createdate Thu, 25 Oct 2012 00:00:00 GMT
 */

if(!defined('NV_IS_MOD_RSS'))die('Stop!!!');$rssarray=array();$sql="SELECT `id` AS `catid`, `parentid`, `title`, `alias` FROM `".NV_PREFIXLANG."_".$mod_name."_categories` ORDER BY `weight` ASC";$list=nv_db_cache($sql,'',$mod_name);foreach($list as $value){$value['link']=NV_BASE_SITEURL."index.php?".NV_LANG_VARIABLE."=".NV_LANG_DATA."&amp;".NV_NAME_VARIABLE."=".$mod_name."&amp;".NV_OP_VARIABLE."=rss/".$value['alias'];$rssarray[]=$value;}

?>