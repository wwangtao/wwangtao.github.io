<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!'); ?>
<div class="containertitle"><b>静态化管理</b> <span id="em_static_info"></span></div>
<div class="line"></div>
<div class="em_static">
	<div class="containertitle2">
		<a class="navi3" href="?plugin=em_static&do=home">日志生成</a>
		<a class="navi4" href="?plugin=em_static&do=create_all">全站生成</a>
		<a class="navi4" href="?plugin=em_static&do=tag_alias">标签别名</a>
		<a class="navi4" href="?plugin=em_static&do=config">功能设置</a>
		<a class="navi4" href="?plugin=em_static&do=url">URL格式管理</a>
		
	</div>
	<?php include em_static_template('warning');?>
	<div style="padding: 10px; height: 300px; position: absolute; width: 400px; margin-left: 400px;">
		日志：
		<div class="line"></div>
		<div id="em_static_msg" style="height: 300px; overflow-y: auto; color: #ccc;"></div>
	</div>	
	
	<h2>日志列表</h2>
	<form method="get">
		<input type="hidden" name="plugin" value="em_static" />
		<input type="text" name="keyword" /><input value="搜索" type="submit"/>
	</form>
	<form method="post" target="working_frame" action="<?php echo BLOG_URL.'content/plugins/em_static/em_static_hook.php?do=create_log_start'?>">
	<?php if ($logs):?>
		<?php foreach($logs as $log):?>
		<div style="line-height: 24px; width: 400px;">
			<input type="checkbox" name="logid[]" style="vertical-align: middle" value="<?php echo $log['gid']?>" />
			<?php echo subString($log['title'], 0, 40) ?>
		</div>
		<?php endforeach;?>
		<p><?php echo $page_html?></p>
		<div style="margin-top: 10px;">
			<input type="submit" value="生成选中的日志及日志相关的静态页面" />
		</div>		
	<?php else:?>
		没有日志
	<?php endif;?>
	</form>	
	<iframe src="" style="width: 400px; height: 150px; border: 0;" id="working_frame" name="working_frame"></iframe>
</div>