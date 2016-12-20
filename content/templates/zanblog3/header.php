<?php
/*
Template Name:ZanBlog
Description:扁平化设计,高端大气上档次
Version:3.0
Author:Flyer
Author Url:http://flyercn.com
Sidebar Amount:1
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
extract(_g());
require_once View::getView('module');
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="zh-CN"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="zh-CN"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="zh-CN"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="zh-CN"><![endif]-->
<html lang="zh-CN">
<head>
<?php if (blog_tool_ishome()) :?> 
<title><?php echo $site_title; ?>-<?php echo $site_description; ?></title>
<?php else:?> 
<title><?php echo $site_title; ?></title> 
<?php endif;?> 
<?php if (isset($logid)) : ?>
<meta name="keywords" content="<?php log_key_words($logid); ?>" />
<?php elseif (isset($sortName)) : ?>
<meta name="keywords" content="<?php echo _g('sortKeywords.'.$sortid); ?>" />
<?php else : ?>
<meta name="keywords" content="<?php echo $site_key; ?>" />
<?php endif; ?>
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="generator" content="emlog" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel='stylesheet' id='bootstrap-css'  href='http://libs.useso.com/js/bootstrap/3.1.1/css/bootstrap.min.css?ver=3.1.1' type='text/css' media='all' />
<link rel='stylesheet' id='fontawesome-css'  href='http://libs.useso.com/js/font-awesome/4.2.0/css/font-awesome.min.css?ver=4.2.0' type='text/css' media='all' />
<link rel='stylesheet' id='flexslider-css'  href='http://libs.useso.com/js/flexslider/2.2.0/flexslider-min.css?ver=2.0' type='text/css' media='all' />
<link rel='stylesheet' id='zan-css'  href='/content/templates/zanblog3/ui/css/zan.css?ver=3.0.0' type='text/css' media='all' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<?php if(_g('color')){?>
<style type="text/css">
a:hover{color:<?php echo _g('color');?>}.header,.panel.panel-zan .panel-heading,.label-zan,.slide-text,.day,.audiojs .scrubber .loaded,.zan-author .author-bottom{background-color:<?php echo _g('color');?>}nav.navbar-inverse .navbar-nav li.current-menu-item>a,nav.navbar-inverse .navbar-nav li.current-menu-parent>a,.addcomment input{border-color:<?php echo _g('color');?>}.header .logo.animation{box-shadow:#428bca 1px 1px;background-color:<?php echo _g('color');?>}.article-stick,.post-info i,#reply-title,#related-title,.comments-header,.attachment a{color:<?php echo _g('color');?>}.btn-zan-solid-pw,.btn-zan-solid-pi,.pagination-zan span{border:2px solid <?php echo _g('color');?>;background-color:<?php echo _g('color');?>}#reply-title,#related-title,.comments-header{border-bottom:2px solid <?php echo _g('color');?>}#commentform #submit,.pager li>a,.btn-zan-line-pp,.btn-zan-line-pp .badge,.pagination-zan>a ,.addcomment #submit{color:<?php echo _g('color');?>;border:2px solid <?php echo _g('color');?>}#commentform #submit:hover,.pager li>a:hover,.login-form .input-group-addon,#commentform .input-group .input-group-addon,.pagination-zan>a:hover,.addcomment .input-group .input-group-addon{background-color:<?php echo _g('color');?>;border:2px solid <?php echo _g('color');?>}nav.navbar-inverse ul.dropdown-menu a:hover,.btn-zan-solid-ip:hover{background-color:<?php echo _g('color');?>!important}nav.navbar-inverse .open a{border-bottom:3px solid <?php echo _g('color');?>}nav.navbar-inverse .open a:hover{border-bottom:3px solid <?php echo _g('color');?>}#commentform textarea:focus,#searchform input:focus,#commentform input,.attachment a,.form-control:focus,.btn-zan-line-pp:hover,.addcomment #submit,.btn-zan-solid-ip:hover{border:2px solid <?php echo _g('color');?>}.attachment a:hover,.btn-zan-line-pp:hover .badge,.btn-zan-line-pp:hover,.top_post .title {background-color:<?php echo _g('color');?>}
</style>
<?php }?>
<?php if(_g('colors')){?>
<style type="text/css">
nav.navbar-inverse,.login-panel,.audiojs,.zan-link, .zan-copyright,.zan-author .author-top,#zan-gotop .gotop,.footer-space-line{background-color:<?php echo _g('colors');?>}#zan-gotop .gotop::before{border-right:13px solid <?php echo _g('colors');?>;}#zan-gotop .gotop::after{border-left:13px solid <?php echo _g('colors');?>}nav.navbar-inverse .open a:hover{background-color:<?php echo _g('colors');?>!important;}.zan-copyright:before{right:0;background-image:-webkit-linear-gradient(top left, #fff 50%, <?php echo _g('colors');?> 50%);background-image:linear-gradient(315deg, #fff 50%, <?php echo _g('colors');?> 50%);}.week,.day,.sun,.zan-category a:hover{background:<?php echo _g('colors');?>}.btn-zan-solid-ip{background-color: <?php echo _g('colors');?>;border: 2px solid <?php echo _g('colors');?>;}
</style>
<?php }?>
<?php doAction('index_head'); ?>
</head>
<body class="home blog">
  <header id="zan-header">
    <!-- logo -->
    <?php if ($logo == "yes"): ?>
    <div class="header">
      <div class="logo" data-toggle="animation"></div>
    </div>
    <?php else:?>
    <div id="header"></div>
     <?php endif; ?>
</div>
  </div>
    <!-- logo结束 -->
    <!-- 导航 -->
    <nav class="navbar navbar-inverse" id="zan-nav">
      <div class="container">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">下拉框</span>
          <span class="fa fa-reorder fa-lg"></span>
        </button>
        <div class="navbar-collapse collapse">
          <ul id="menu-navbar" class="nav navbar-nav">
          <?php blog_navi();?>
          </ul>
        </div>
      </div>
    </nav>
  </header>