<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_global.inc.php"); //载入通用
include_once(BG_PATH_CLASS . "base.class.php"); //载入模板类
include_once(BG_PATH_CONTROL_ADMIN . "ajax/seccode.class.php"); //载入登录控制器

$GLOBALS["obj_base"]    = new CLASS_BASE(); //初始化模板对象
$ajax_seccode           = new AJAX_SECCODE();

switch ($act_get) {
	case "chk":
		$ajax_seccode->ajax_check();
	break;
}
?>