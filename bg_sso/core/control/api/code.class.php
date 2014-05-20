<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

include_once(BG_PATH_FUNC . "baigocode.func.php"); //载入模板类
include_once(BG_PATH_CLASS . "api.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "app.class.php"); //载入后台用户类
include_once(BG_PATH_MODEL . "log.class.php"); //载入管理帐号模型

/*-------------用户类-------------*/
class API_CODE {

	private $obj_api;
	private $log;
	private $mdl_app;
	private $appAllow;
	private $appGet;

	function __construct() { //构造函数
		$this->obj_api    = new CLASS_API();
		$this->log        = $this->obj_api->log; //初始化 AJAX 基对象
		$this->mdl_app    = new MODEL_APP(); //设置管理组模型
		$this->mdl_log    = new MODEL_LOG(); //设置管理员模型
	}


	/**
	 * api_chkapp function.
	 *
	 * @access private
	 * @return void
	 */
	private function api_chkapp($str_method = "get") {
		$this->appGet = $this->obj_api->app_get($str_method);
		if ($this->appGet["str_alert"] != "ok") {
			$this->log_do($this->appGet, "get");
			$this->obj_api->halt_re($this->appGet);
		}

		$_arr_appRow = $this->mdl_app->mdl_read($this->appGet["app_id"]);
		if ($_arr_appRow["str_alert"] != "y050102") {
			$this->log_do($_arr_appRow, "read");
			$this->obj_api->halt_re($_arr_appRow);
		}
		$this->appAllow = json_decode($_arr_appRow["app_allow"], true);

		$_arr_appChk = $this->obj_api->app_chk($this->appGet, $_arr_appRow);
		if ($_arr_appChk["str_alert"] != "ok") {
			$this->log_do($_arr_appChk, "check");
			$this->obj_api->halt_re($_arr_appChk);
		}
	}


	/**
	 * log_do function.
	 *
	 * @access private
	 * @param mixed $arr_logResult
	 * @param mixed $str_logType
	 * @return void
	 */
	private function log_do($arr_logResult, $str_logType) {
		$_arr_targets[] = array(
			"app_id" => $this->appGet["app_id"],
		);
		$_str_targets     = json_encode($_arr_targets);
		$_str_logResult   = json_encode($arr_logResult);
		$this->mdl_log->mdl_submit($_str_targets, "app", $this->log["app"][$str_logType], $_str_logResult, "app", $this->appGet["app_id"]);
	}


	/**
	 * api_signature function.
	 *
	 * @access public
	 * @return void
	 */
	function api_signature() {
		$this->api_chkapp("get");

		if ($this->appAllow["code"]["signature"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050312",
			);

			$this->log_do($_arr_return, "signature");
			$this->obj_api->halt_re($_arr_return);
		}

		$_tm_time     = $_GET["timestamp"];
		$_str_rand    = $_GET["random"];
		$_str_sign    = fn_baigoSignMk($_tm_time, $_str_rand);

		$_arr_return = array(
			"signature"  => $_str_sign,
			"str_alert"  => "y050404",
		);

		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_verify function.
	 *
	 * @access public
	 * @return void
	 */
	function api_verify() {
		$this->api_chkapp("get");

		if ($this->appAllow["code"]["verify"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050313",
			);
			$this->log_do($_arr_return, "verify");
			$this->obj_api->halt_re($_arr_return);
		}

		$_tm_time     = $_GET["timestamp"];
		$_str_rand    = $_GET["random"];
		$_str_sign    = $_GET["signature"];

		if (fn_baigoSignChk($_tm_time, $_str_rand, $_str_sign)) {
			$_str_alert = "y050403";
		} else {
			$_str_alert = "x050403";
		}

		$_arr_return = array(
			"str_alert" => $_str_alert,
		);

		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_encode function.
	 *
	 * @access public
	 * @return void
	 */
	function api_encode() {
		$this->api_chkapp("get");
		if ($this->appAllow["code"]["encode"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050314",
			);
			$this->log_do($_arr_return, "encode");
			$this->obj_api->halt_re($_arr_return);
		}

		$_str_userRand    = fn_rand(6);
		$_str_code        = $this->obj_api->api_encode($_arr_userRow, $_str_userRand);

		$_arr_return = array(
			"code"       => $_str_code,
			"key"        => $_str_userRand,
			"str_alert"  => "y050405",
		);

		$this->obj_api->halt_re($_arr_return);
	}


	/**
	 * api_decode function.
	 *
	 * @access public
	 * @return void
	 */
	function api_decode() {
		$this->api_chkapp("get");
		if ($this->appAllow["code"]["decode"] != 1) {
			$_arr_return = array(
				"str_alert" => "x050315",
			);
			$this->log_do($_arr_return, "decode");
			$this->obj_api->halt_re($_arr_return);
		}

		$_str_code    = $_GET["code"];
		$_str_key     = $_GET["key"];
		$_str_result  = fn_baigoDecode($_str_code, $_str_key);

		exit($_str_result);
	}
}
?>