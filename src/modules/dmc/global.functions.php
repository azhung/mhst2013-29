<?php

/**
 * @Project Quan Ly Doan Vien
 * @Author MHST2013-29
 * @copyright 2013
 * @createdate 19/7/2013 10:10 AM
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

function getAllLienChi( )
{
   global $module_data, $db;

   $data = array() ;
   $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lienchi` ";
   $result = $db->sql_query( $sql );
      
   
   while ( list ( $lc_id, $lc_name, $lc_mota ) = $db->sql_fetchrow($result) )
   {
      $data[] = array (
         "lc_id" => $lc_id,
         "lc_name" => $lc_name,
         "lc_mota" => $lc_mota
      );
   }
   return $data ;
}

function getAllKhoaHoc( )
{
   global $module_data, $db;

   $data = array() ;
   $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_khoahoc` ";
   $result = $db->sql_query( $sql );   
   
   while ( list ( $kh_id, $kh_name, $kh_hdt, $kh_ngayvao, $kh_ngayra ) = $db->sql_fetchrow($result) )
   {
      $data[] = array (
         "kh_id" => $kh_id,
         "kh_name" => $kh_name,
         "kh_hdt" => $kh_hdt,
         "kh_ngayvao" => date( "d/m/Y", $kh_ngayvao ),
         "kh_ngayra" => date( "d/m/Y", $kh_ngayra )                 
      );
	  //date( "d/m/Y", $row['ngaysinh'] )
   }
   return $data ;
}

?>