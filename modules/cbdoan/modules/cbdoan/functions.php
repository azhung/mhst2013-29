<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Fri, 10 Aug 2012 16:11:38 GMT
 */

if( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_CBDOAN', true );

//Hien thi danh sach don vi
function getDonvi()
{
   global $module_data, $db;
   $donvi = array();
   
   $result = $db->sql_query( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi`");
   while ( list ( $madvi, $tendvi ) = $db->sql_fetchrow($result) )
   {
      $donvi[] = array (
         "madvi" => $madvi,
         "tendvi" => $tendvi
      );
   }
   return $donvi ;
}

if($global_config['is_url_rewrite']==1)
{
	$count_op = sizeof( $array_op );

	if( ! empty( $array_op ) and $op == "main" )
	{	
		$op = "main";
		if( $count_op == 1 )
		{
			$array_page = explode( "-", $array_op[0] );
			
			$id = intval( $array_page[0] );
			
			$number = strlen( $id ) + 1;
			$alias_url = substr( $array_op[0], 0, -$number );
			
			if( $id > 0 and $alias_url != "" )
			{
				//var_dump($alias_url);
				$op = "detail";
			}
		}
	}

}
?>