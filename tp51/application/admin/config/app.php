<?php
/**
 * 后台模块配置文件
 * User: 新
 * Date: 2018/11/21
 * Time: 19:23
 */
return [
    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'admin',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Article',
    // 默认操作名
    'default_action'         => 'article',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空模块名
    'empty_module'           => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法前缀
    'use_action_prefix'      => false,
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------
    // 应用调试模式
    'app_debug'              => true,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => [],
    //'strip_tags','htmlspecialchars','trim'
];