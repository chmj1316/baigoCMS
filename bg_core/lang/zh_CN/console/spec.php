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

    'page' => array(
        'add'   => '创建',
        'edit'  => '编辑',
        'select'    => '选择文章',
    ),

    /*------链接文字------*/
    'href' => array(
        'add'   => '创建',
        'help'  => '帮助',
        'edit'  => '编辑', //编辑
        'select'    => '选择文章',
        'uploadList'    => '上传或插入', //上传或插入
    ),

    /*------说明文字------*/
    'label' => array(
        'id'            => 'ID', //ID
        'all'           => '全部',
        'key'           => '关键词', //关键词
        'timePub'       => '定时上线',
        'timeHide'      => '定时下线',

        'status'        => '状态',
        'specName'      => '专题名称',
        'specContent'   => '专题内容',

        'belongArticle'   => '已选文章',
        'selectArticle'   => '待选文章',
    ),

    'status' => array(
        'show'  => '显示', //正常
        'hide'  => '隐藏', //隐藏
        'pub'   => '发布', //发布
        'wait'  => '待审', //等待审核
        'top'   => '置顶',
    ),

    'option' => array(
        'allStatus' => '所有状态', //所有
        'allCate'   => '所有栏目', //所有栏目
        'batch'     => '批量操作', //批量操作
        'del'       => '永久删除', //删除
        'unknown'   => '未知', //未知
    ),

    'btn' => array(
        'save'          => '保存', //提交
        'submit'        => '提交', //提交
        'belongAdd'     => '选择',
        'belongDel'     => '移出',
        'genSingle'     => '生成',
    ),

    'confirm' => array(
        'del' => '确认永久删除吗？此操作不可恢复！', //确认清空回收站
    ),
);
