<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_INC . "common_admin.inc.php"); //验证是否已登录
include_once(BG_PATH_CONTROL_ADMIN . "ajax/upfile.class.php"); //载入登录控制器
$ajax_upfile = new AJAX_UPFILE();

switch ($act_post) {
	case "submit":
		$ajax_upfile->ajax_submit();
	break;

	case "del":
		$ajax_upfile->ajax_del();
	break;
}
?>