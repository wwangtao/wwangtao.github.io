<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function callback_init() {
	require_once EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud.php';
	tag_cloud_update();
	tag_cloud_init();
}