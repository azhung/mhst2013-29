<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Fri, 10 Aug 2012 16:11:38 GMT
 */

if( ! defined( 'NV_IS_MOD_CBDOAN' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];

$xtpl = new XTemplate( "detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );

if($global_config['is_url_rewrite']==0)
{
    $id  = $array_op[1];
    $id=explode('-', $id);
    $id=$id[0];
}

if(!$id)
{
    Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name);
}
    
$sql = "SELECT CB.*, CV.tenchucvu AS CHUCVU1, CV2.tenchucvu AS CHUCVU2, CV3.tenchucvu AS CHUCVU3, DV.tendonvi  FROM `" . NV_PREFIXLANG . "_" . $module_data . "` 
    CB LEFT JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV ON CB.macvu1=CV.macvu LEFT JOIN `" 
    . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV2 ON CB.macvu2=CV2.macvu
    LEFT JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu` CV3 ON CB.macvu3=CV3.macvu
    LEFT JOIN `" . NV_PREFIXLANG . "_" . $module_data . "_donvi` DV ON CB.madvi=DV.madvi WHERE id = " . $id;
$result = $db->sql_query( $sql );

while( $row = $db->sql_fetchrow( $result ) )
{
    $row['gtinh'] == 1 ? $row['gtinh'] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/cbdoan/male.png" : 
                         $row['gtinh'] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/cbdoan/female.png";
    
    $row['dang'] == 1 ? $row['dang'] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/cbdoan/check.png" : 
                        $row['dang'] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/cbdoan/no.png";
    
    $madvi = $row['madvi'];
    $cv2 = $row['macvu2'];
    $cv3 = $row['macvu3'];
    $nvdoan = $row['nvdoan'];
    $nvdang = $row['nvdang'];
    $quequan = $row['quequan'];
    $diachi = $row['diachi'];
    $email = $row['email'];
    $lienchi = $row['lienchi'];
    $web = $row['website'];
    $kyluat = $row['kyluat'];
    $doanphi = $row['doanphi'];
    $nhanxet= $row['nhanxet'];
    $xtpl->assign( 'TITLE', sprintf($lang_module['tieudecb'], $row['hoten'] ));
    $xtpl->assign( 'ROW', $row );
}

$cv2 != 0 ? $xtpl->parse( 'main.cv2' ) : "";
$cv3 != 0 ? $xtpl->parse( 'main.cv3' ) : "";
$nvdoan != "" ? $xtpl->parse( 'main.nvdoan' ) : "";
$nvdang != "" ? $xtpl->parse( 'main.nvdang' ) : "";
$quequan != "" ? $xtpl->parse( 'main.quequan' ) : "";
$diachi != "" ? $xtpl->parse( 'main.diachi' ) : "";
$email != "" ? $xtpl->parse( 'main.k_onl.email' ) : "";
$lienchi!= "" ? $xtpl->parse( 'main.k_onl.lienchi' ) : "";
$web != "" ? $xtpl->parse( 'main.k_onl.web' ) : "";
$kyluat!= "" ? $xtpl->parse( 'main.k_onl.kyluat' ) : "";
$doanphi  != "" ? $xtpl->parse( 'main.k_onl.doanphi' ) : "";
$nhanxet != "" ? $xtpl->parse( 'main.tomtat' ) : "";


//dem so can bo cung don vi
$sql1 = "SELECT count(*) FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE madvi=" . $madvi;
$result1 = $db->sql_query($sql1);
list( $num ) = $db->sql_fetchrow( $result1 );

//Dinh dang link xem cac can bo cung don vi
$xtpl->assign( 'DV_LINK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . 
                "=" . $module_name . "&amp;madvi=" . $madvi );
                
//Hien thi thong tin
$xtpl->assign( 'DV_K', sprintf($lang_module['view_dv'], $num ) );

//Lay thong tin cau hinh gan cho cac bien tuong ung
$sql2= "SELECT search FROM `" . NV_PREFIXLANG . "_" . $module_data . "_config`";
$conf = $db->sql_query($sql2);
list($search) = $db->sql_fetchrow($conf);

//Bat tat tim kiem
if( $search == 1 )
{
    $xtpl->assign( 'ACTION', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name );
    $xtpl->parse( 'main.search' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>