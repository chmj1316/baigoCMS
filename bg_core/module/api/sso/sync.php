<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

require(BG_PATH_INC . "common.inc.php");
require(BG_PATH_FUNC . "init.func.php");
$arr_set = array(
    "base"          => true,
    "ssin"          => true,
    "db"            => true,
);
fn_init($arr_set);

$ctrl_sync = new CONTROL_API_SSO_SYNC();

switch ($GLOBALS["act"]) {
    case "login":
        $ctrl_sync->ctrl_login();
    break;

    case "logout":
        $ctrl_sync->ctrl_logout();
    break;
}
