<?php

/**
 * @Project NUKEVIET 3.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN'))
	die('Stop!!!');

$submenu['cbdoan_add'] = $lang_module['cbdoan_add'];
$submenu['donvi'] = $lang_module['dsdonvi'];
$submenu['chucvu'] = $lang_module['dschucvu'];
$submenu['import'] = $lang_module['data_manage'];
$submenu['config'] = $lang_module['config'];
$allow_func = array('main', 'cbdoan_add', 'cbdoan_edit', 'donvi', 'donvi_add', 'donvi_edit', 'thuchi', 'thuchi_add', 'thuchi_edit', 'chucvu', 'chucvu_add', 'chucvu_edit', 'import', 'config');

define('NV_IS_FILE_ADMIN', true);

//Hien thi danh sach don vi
function getDonvi() {
	global $module_data, $db;
	$donvi = array();

	$result = $db -> sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_donvi`");
	while (list($madvi, $tendvi, $gt_dv) = $db -> sql_fetchrow($result)) {
		$donvi[] = array("madvi" => $madvi, "tendvi" => $tendvi, "gt_dv" => $gt_dv);
	}
	return $donvi;
}

//Hien thi danh sach chuc vu
function getChucvu() {
	global $module_data, $db;
	$chucvu = array();

	$result = $db -> sql_query("SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_chucvu`");
	while (list($macvu, $tenchucvu, $gt_cv) = $db -> sql_fetchrow($result)) {
		$chucvu[] = array("macvu" => $macvu, "tenchucvu" => $tenchucvu, "gt_cv" => $gt_cv);
	}
	return $chucvu;
}
?>