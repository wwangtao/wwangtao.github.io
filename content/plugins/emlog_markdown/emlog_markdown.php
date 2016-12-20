<?php
/*
Plugin Name: MarkDown for Emlog大前端
Version: 1.0
Plugin URL: http://blog.yesfree.pw
Description: 将emlog编辑器替换为markdown，方便写博客
Author: 小草
Author Email: 34109680@qq.com
Author URL: http://blog.yesfree.pw
*/
!defined('EMLOG_ROOT') && exit('access deined!');

// DO HOOK
addAction('adm_writelog_head', 'emlog_markdown');

function emlog_markdown() {
  require 'emlog_markdown_html.php';
}