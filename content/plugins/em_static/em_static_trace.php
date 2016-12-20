<?php
include '../../../init.php';
header('Content-type: text/javascript; charset=utf-8;');

$logid = isset($_GET['logid']) ? intval($_GET['logid']) : 0;
if (empty($logid) || ! isset($GLOBALS['em_static_config_data']) || $GLOBALS['em_static_config_data']['enable_click_trace'] == 0)
	exit();
$sql = 'UPDATE '.DB_PREFIX.'blog SET views = views + 1 WHERE gid = '.$logid;
Mysql::getInstance()->query($sql);