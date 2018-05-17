<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------------------通用-------------------------*/
return array(

    'href' => array(
        'add'   => '创建',
        'help'  => '帮助',
        'edit'  => '编辑', //编辑
    ),

    /*------说明文字------*/
    'label' => array(
        'id'            => 'ID',
        'all'           => '全部',
        'tag'           => 'TAG', //TAG
        'status'        => '状态',
        'articleCount'  => '文章数',
        'noname'        => '未命名', //未命名
        'key'           => '关键词',
    ),

    'status' => array(
        'show'  => '显示', //正常
        'hide'  => '隐藏', //隐藏
    ),

    'option' => array(
        'allStatus' => '所有状态', //所有
        'batch'     => '批量操作', //批量操作
        'del'       => '永久删除', //删除
    ),

    'confirm' => array(
        'del' => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
    ),

    'btn' => array(
        'save'          => '保存', //提交
        'submit'        => '提交', //提交
    ),
);