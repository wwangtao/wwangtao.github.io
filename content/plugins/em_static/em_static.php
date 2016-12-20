<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!');
/*
Plugin Name: EMLOG静态化插件
Version: 1.5.7
Plugin URL: http://www.emlog.net/plugin/134
Description: EMLOG静态化插件
Author: EMLOG开发组
Author URL: http://www.emlog.net/
*/

define('EM_STATIC_ROOT', EMLOG_ROOT.'/content/plugins/em_static');

require_once EM_STATIC_ROOT.'/em_static_const.php';
require_once EM_STATIC_ROOT.'/em_static_func.php';
define('EM_STATIC_VERSION', '1.5.6');

if ( ! is_file(EM_STATIC_CONFIG_DATA_FILE)) {
	em_static_write_config_data();
}

$GLOBALS['em_static_config_data'] = include EM_STATIC_CONFIG_DATA_FILE;

// 自动创建新的url配置文件
if ( ! is_file(EM_STATIC_CONFIG_FILE) ) {
	em_static_write_url_config_data();
}
addAction('data_prebakup', 'em_static_add_datatable');
addAction('adm_sidebar_ext', 'em_static_menu');
addAction('save_log', 'em_static_recreate_tag_cache');

if ($GLOBALS['em_static_config_data']['enable_click_trace'] == 1) {
	addAction('log_related', 'em_static_print_click_trace_js');
}
// 开启自动生成才挂上钩子
if ($GLOBALS['em_static_config_data']['enable_auto_create'] == 1) {
	addAction('save_log', 'em_static_update_post');
	// emlog 5.1  新支持的钩子
	addAction('before_del_log', 'em_static_delete_post');
	addAction('comment_saved', 'em_static_update_comment');	
	addAction('adm_footer', 'em_static_print_cront_js');
	addAction('index_footer', 'em_static_print_cront_js');
}

function em_static_menu() {
	echo '<div class="sidebarsubmenu" id="em_static"><a href="./plugin.php?plugin=em_static">静态化</a></div>';
}

