<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------设置项模型-------------*/
class MODEL_OPT {

    function __construct() { //构造函数
        $this->obj_file  = new CLASS_FILE();
    }

    function mdl_const($str_type) {
        $_str_outPut = '<?php' . PHP_EOL;
        foreach ($this->arr_const[$str_type] as $_key=>$_value) {
            if (is_numeric($_value)) {
                $_str_outPut .= 'define(\'' . $_key . '\', ' . $_value . ');' . PHP_EOL;
            } else {
                $_str_outPut .= 'define(\'' . $_key . '\', \'' . rtrim(str_ireplace(PHP_EOL, '|', $_value), '/\\') . '\');' . PHP_EOL;
            }
        }

        switch ($str_type) {
            case 'base':
                if (!isset($this->arr_const[$str_type]['BG_SITE_SSIN'])) {
                    $_str_outPut .= 'define(\'BG_SITE_SSIN\', \'' . fn_rand(6) . '\');' . PHP_EOL;
                }
            break;

            case 'visit':
                if (!isset($this->arr_const[$str_type]['BG_VISIT_FILE'])) {
                    $_str_outPut .= 'define(\'BG_VISIT_FILE\', \'html\');' . PHP_EOL;
                }
                if (!isset($this->arr_const[$str_type]['BG_VISIT_PAGE'])) {
                    $_str_outPut .= 'define(\'BG_VISIT_PAGE\', 10);' . PHP_EOL;
                }
            break;
        }

        $_str_outPut = str_ireplace('||', '', $_str_outPut);

        $_num_size = $this->obj_file->file_put(BG_PATH_CONFIG . 'opt_' . $str_type . '.inc.php', $_str_outPut);

        if ($_num_size > 0) {
            $_str_rcode = 'y060101';
        } else {
            $_str_rcode = 'x060101';
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function mdl_dbconfig() {
        $_str_outPut = '<?php' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_DB_HOST\', \'' . $this->dbconfigInput['db_host'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_DB_NAME\', \'' . $this->dbconfigInput['db_name'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_DB_PORT\', \'' . $this->dbconfigInput['db_port'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_DB_USER\', \'' . $this->dbconfigInput['db_user'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_DB_PASS\', \'' . $this->dbconfigInput['db_pass'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_DB_CHARSET\', \'' . $this->dbconfigInput['db_charset'] . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_DB_TABLE\', \'' . $this->dbconfigInput['db_table'] . '\');' . PHP_EOL;

        $_num_size = $this->obj_file->file_put(BG_PATH_CONFIG . 'opt_dbconfig.inc.php', $_str_outPut);

        if ($_num_size > 0) {
            $_str_rcode = 'y030404';
        } else {
            $_str_rcode = 'x030404';
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function mdl_htaccess() {
        $_str_outPut = '# BEGIN baigo CMS' . PHP_EOL;
        $_str_outPut .= '<IfModule mod_rewrite.c>' . PHP_EOL;
            $_str_outPut .= 'RewriteEngine On' . PHP_EOL;
            $_str_outPut .= 'RewriteBase ' . BG_URL_ROOT . PHP_EOL;

            $_str_outPut .= '# 确保请求路径不是一个文件名或目录' . PHP_EOL;
            $_str_outPut .= 'RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL;
            $_str_outPut .= 'RewriteCond %{REQUEST_FILENAME} !-d' . PHP_EOL;

            $_str_outPut .= '# 重定向所有请求到 index.php?route=PATHNAME' . PHP_EOL;
            $_str_outPut .= 'RewriteRule ^(.*)$ ' . BG_URL_ROOT . 'index.php?pathname=$1 [PT,L]' . PHP_EOL;
        $_str_outPut .= '</IfModule>' . PHP_EOL;
        $_str_outPut .= '# END baigo CMS' . PHP_EOL;

        $_num_size = $this->obj_file->file_put(BG_PATH_ROOT . '.htaccess', $_str_outPut);

        if ($_num_size > 0) {
            $_str_rcode = 'y060101';
        } else {
            $_str_rcode = 'x060101';
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function mdl_over() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $_str_outPut = '<?php' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_INSTALL_VER\', \'' . PRD_CMS_VER . '\');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_INSTALL_PUB\', ' . PRD_CMS_PUB . ');' . PHP_EOL;
        $_str_outPut .= 'define(\'BG_INSTALL_TIME\', ' . time() . ');' . PHP_EOL;

        $_num_size = $this->obj_file->file_put(BG_PATH_CONFIG . 'installed.php', $_str_outPut);

        if ($_num_size > 0) {
            $_str_rcode = 'y060101';
        } else {
            $_str_rcode = 'x060101';
        }

        return array(
            'rcode' => $_str_rcode,
        );
    }


    function input_dbconfig() {
        if (!fn_token('chk')) { //令牌
            return array(
                'rcode' => 'x030206',
            );
        }

        $_arr_dbHost = fn_validate(fn_post('db_host'), 1, 900);
        switch ($_arr_dbHost['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x060204',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x060205',
                );
            break;

            case 'ok':
                $this->dbconfigInput['db_host'] = $_arr_dbHost['str'];
            break;
        }

        $_arr_dbName = fn_validate(fn_post('db_name'), 1, 900);
        switch ($_arr_dbName['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x060206',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x060207',
                );
            break;

            case 'ok':
                $this->dbconfigInput['db_name'] = $_arr_dbName['str'];
            break;
        }

        $_arr_dbPort = fn_validate(fn_post('db_port'), 1, 900);
        switch ($_arr_dbPort['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x060208',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x060209',
                );
            break;

            case 'ok':
                $this->dbconfigInput['db_port'] = $_arr_dbPort['str'];
            break;
        }

        $_arr_dbUser = fn_validate(fn_post('db_user'), 1, 900);
        switch ($_arr_dbUser['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x060210',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x060211',
                );
            break;

            case 'ok':
                $this->dbconfigInput['db_user'] = $_arr_dbUser['str'];
            break;
        }

        $_arr_dbPass = fn_validate(fn_post('db_pass'), 1, 900);
        switch ($_arr_dbPass['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x060212',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x060213',
                );
            break;

            case 'ok':
                $this->dbconfigInput['db_pass'] = $_arr_dbPass['str'];
            break;
        }

        $_arr_dbCharset = fn_validate(fn_post('db_charset'), 1, 900);
        switch ($_arr_dbCharset['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x060214',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x060215',
                );
            break;

            case 'ok':
                $this->dbconfigInput['db_charset'] = $_arr_dbCharset['str'];
            break;
        }

        $_arr_dbtable = fn_validate(fn_post('db_table'), 1, 900);
        switch ($_arr_dbtable['status']) {
            case 'too_short':
                return array(
                    'rcode' => 'x060216',
                );
            break;

            case 'too_long':
                return array(
                    'rcode' => 'x060217',
                );
            break;

            case 'ok':
                $this->dbconfigInput['db_table'] = $_arr_dbtable['str'];
            break;
        }

        $this->dbconfigInput['rcode'] = 'ok';

        return $this->dbconfigInput;
    }


    function input_const($str_type) {
        $this->arr_const = fn_post('opt');

        return $this->arr_const[$str_type];
    }


    function chk_ver($is_check = false, $method = 'auto') {
        if (!file_exists(BG_PATH_CACHE . 'sys' . DS . 'latest_ver.json')) {
            $this->ver_process($method);
        }

        $_str_ver = $this->obj_file->file_read(BG_PATH_CACHE . 'sys' . DS . 'latest_ver.json');
        $_arr_ver = json_decode($_str_ver, true);

        if ($is_check || !$_arr_ver || !isset($_arr_ver['time']) || $_arr_ver['time'] - time() > 30 * 86400 || isset($_arr_ver['err'])) {
            $this->ver_process($method);
            $_str_ver = $this->obj_file->file_read(BG_PATH_CACHE . 'sys' . DS . 'latest_ver.json');
            $_arr_ver = json_decode($_str_ver, true);
        }

        if (isset($_arr_ver['prd_pub'])) {
            $_arr_ver['prd_pub'] = strtotime($_arr_ver['prd_pub']);
        }

        return $_arr_ver;
    }


    function ver_process($method = 'auto') {
        $_arr_data = array(
            'name'      => 'baigo CMS',
            'ver'       => PRD_CMS_VER,
            'referer'   => fn_forward(fn_server('SERVER_NAME') . BG_URL_ROOT),
            'method'    => $method,
        );

        $_str_ver = fn_http(PRD_VER_CHECK, $_arr_data, 'get');

        $this->obj_file->file_put(BG_PATH_CACHE . 'sys' . DS . 'latest_ver.json', $_str_ver['ret']);
    }
}
