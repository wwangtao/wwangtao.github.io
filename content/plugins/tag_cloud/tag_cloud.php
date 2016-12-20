<?php
/*
Plugin Name: 3D标签云
Version:2.0
Plugin URL:http://www.cooron.com
Description: 移植WP的经典3D标签云插件，使其完美支持EMLOG，对SEO无影响。同时大幅度缩小了插件SWF的大小，并且全面支持中文。
Author:Kuma
Author Email: artmemory@qq.com
Author URL: http://www.cooron.com
*/
if(!defined('EMLOG_ROOT')) {exit('error!');};
addAction('save_log', 'tag_cloud_update');
include_once(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php');
function tag_cloud_menu()//写入插件导航
{
	echo '<div class="sidebarsubmenu" id="tag_cloud"><a href="./plugin.php?plugin=tag_cloud">3D标签云设置</a></div>';
}
addAction('adm_sidebar_ext', 'tag_cloud_menu');
function tag_cloud_side()//为SEO而写的隐藏标签链接
{
	$CACHE = Cache::getInstance();
    $tag_cache = $CACHE->readCache('tags');
    echo '<div style="display:none">';
    foreach($tag_cache as $value)
    {
		echo '<a href="'. Url::tag($value['tagurl']) .'" title="'.$value['usenum'].'篇日志" rel="tag">'.$value['tagname'].'</a>';
	}
	echo '</div>';
}
addAction('diff_side', 'tag_cloud_side');
/**function tag_cloud_head()
{
  echo '<script type="text/javascript" src="'.BLOG_URL.'content/plugins/tag_cloud/swfobject.js"></script>';
}
addAction('index_head', 'tag_cloud_head');**/
if(isset($_GET['tag_cloud_widgets']))//widgets调用的JS
{
	echo 'document.write(\'<embed tplayername="SWF" splayername="SWF" type="application/x-shockwave-flash" src="'.BLOG_URL.'content/plugins/tag_cloud/tagcloud.swf" mediawrapchecked="true" pluginspage="http://www.macromedia.com/go/getflashplayer" id="tagcloudflash" name="tagcloudflash" bgcolor="'.tag_cloud_bgcolor.'" quality="high" wmode="'.tag_cloud_trans.'" allowscriptaccess="always"  flashvars="tcolor='.tag_cloud_tcolor.'&tcolor2='.tag_cloud_tcolor2.'&hicolor='.tag_cloud_hicolor.'&tspeed='.tag_cloud_tspeed.'&distr=true" width="'.tag_cloud_width.'" height="'.tag_cloud_height.'"></embed>\');';
	exit;
}
function tag_cloud_update(){
	$CACHE = Cache::getInstance();
	$tag_cloud_tags = $CACHE->readCache('tags');
	$tag_cloud_data = "<tags>";
	foreach($tag_cloud_tags as $key => $value)
	{
		$tag_cloud_data .= '<a href="'. Url::tag($value['tagurl']) .'" class="tag-link-'.$key.'" title="'.$value['usenum'].' topics" rel="tag" style="font-size:'.$value['fontsize'].'pt;">'.$value['tagname'].'</a>';
	}
	$tag_cloud_data .= "</tags>";
	$tag_cloud_fp = @fopen("../content/plugins/tag_cloud/tagcloud.xml","w");
	if(!@fwrite($tag_cloud_fp,$tag_cloud_data))
	{
		emMsg('更新文件/content/plugins/tag_cloud/tagcloud.xml失败，请检查该文件是否可写');
	}
    @fclose($tag_cloud_fp);
}
function tag_cloud_init(){
	$DB = MySql::getInstance();
	$CACHE = Cache::getInstance();
	$options_cache = $CACHE->readCache('options');
	//写入widgest
	$custom_widget = $options_cache['custom_widget'] ? @unserialize($options_cache['custom_widget']) : array();
	$tag_cloud_widgets_content = '<script type="text/javascript" src="'.BLOG_URL.'index.php?tag_cloud_widgets"></script>';
	if(is_array($custom_widget))
	{
		if(!in_array('custom_wg_tag_cloud',array_keys($custom_widget)))//如果没有标签云widgets，则添加
		{
			//添加
			$custom_wg_index = 'custom_wg_tag_cloud';
			$custom_widget[$custom_wg_index] = array('title'=>"标签云",'content'=>$tag_cloud_widgets_content);
			$custom_widget_str = addslashes(serialize($custom_widget));
			$DB->query("update ".DB_PREFIX."options set option_value='$custom_widget_str' where option_name='custom_widget'");
			//启用
			$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
			$widgets[] = "custom_wg_tag_cloud";
			$widgets = serialize($widgets);
			$DB->query("update ".DB_PREFIX."options set option_value='$widgets' where option_name='widgets1'");
			$CACHE->updateCache('options');
		}
	}
}
?>
