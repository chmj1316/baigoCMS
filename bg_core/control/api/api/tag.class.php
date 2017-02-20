<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}


/*-------------文章类-------------*/
class CONTROL_API_API_TAG {

    function __construct() { //构造函数
        $this->obj_api        = new CLASS_API();
        //$this->obj_api->chk_install();

        $this->mdl_tag        = new MODEL_TAG();
    }


    /**
     * ctrl_list function.
     *
     * @access public
     * @return void
     */
    function ctrl_read() {
        $_arr_appChk = $this->obj_api->app_chk();
        if ($_arr_appChk["rcode"] != "ok") {
            $this->obj_api->show_result($_arr_appChk);
        }

        $_str_tagName = fn_getSafe(fn_get("tag_name"), "txt", "");

        if (fn_isEmpty($_str_tagName)) {
            $_arr_return = array(
                "rcode" => "x130201",
            );
            $this->obj_api->show_result($_arr_return);
        }

        $_arr_tagRow = $this->mdl_tag->mdl_read($_str_tagName, "tag_name");

        if ($_arr_tagRow["rcode"] != "y130102") {
            $this->obj_api->show_result($_arr_tagRow);
        }

        if ($_arr_tagRow["tag_status"] != "show") {
            $_arr_return = array(
                "rcode" => "x130102",
            );
            $this->obj_api->show_result($_arr_return);
        }

        unset($_arr_tagRow["urlRow"]);

        $this->obj_api->show_result($_arr_tagRow, true);
    }
}
