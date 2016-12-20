<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!'); ?>
<div class="containertitle"><b>静态化管理</b></div>
<div class="line"></div>
<div class="em_static">
	<div class="containertitle2">
		<a class="navi1" href="?plugin=em_static&do=home">日志生成</a>
		<a class="navi4" href="?plugin=em_static&do=create_all">全站生成</a>
		<a class="navi4" href="?plugin=em_static&do=tag_alias">标签别名</a>
		<a class="navi3" href="?plugin=em_static&do=config">功能设置</a>
		<a class="navi4" href="?plugin=em_static&do=url">URL格式管理</a>
	</div>
	<?php include em_static_template('warning');?>
	<form method="post">
		<p><b>静态页面自动生成功能</b></p>
		<p>
			<input type="radio" name="enable_auto_create" value="0" <?php $GLOBALS['em_static_config_data']['enable_auto_create'] == 0 AND print 'checked'?>/>关闭
			<input type="radio" name="enable_auto_create" value="1" <?php $GLOBALS['em_static_config_data']['enable_auto_create'] == 1 AND print 'checked'?>/>开启
		</p>
		<p style="color:#FF6600">开启自动生成功能会增加服务器性能压力，如果站点数据量较大建议关闭本功能改为手动生成</p>
		<p><b>页面自动生成性能阈值</b></p>
		<p>
			<select name="auto_create_performance_value">
			<?php for ($i = 1; $i <= 10; $i++):?>
			<option value="<?php echo $i?>" <?php $GLOBALS['em_static_config_data']['auto_create_performance_value'] == $i AND print 'selected="selected"'?>><?php echo $i?></option>
			<?php endfor;?>
			</select>
		</p>
		<p style="color:#FF6600">数字越大生成速度越快，但是给服务器带来的压力也更大, 请根据站点的实际情况设定</p>
		<p><b>开启静态页日志点击数统计</b></p>
		<p>
			<input type="radio" name="enable_click_trace" value="0" <?php $GLOBALS['em_static_config_data']['enable_click_trace'] == 0 AND print 'checked'?>/>关闭
			<input type="radio" name="enable_click_trace" value="1" <?php $GLOBALS['em_static_config_data']['enable_click_trace'] == 1 AND print 'checked'?>/>开启
		</p>
		<p style="color:#FF6600">开启后可统计日志的查看次数,同时会轻微增加服务器负载.</p>
		<p><b>开启插件调试模式</b></p>
		<p>
			<input type="radio" name="enable_debug_model" value="0" <?php $GLOBALS['em_static_config_data']['enable_debug_model'] == 0 AND print 'checked'?>/>关闭
			<input type="radio" name="enable_debug_model" value="1" <?php $GLOBALS['em_static_config_data']['enable_debug_model'] == 1 AND print 'checked'?>/>开启
		</p>
		<p style="color:#FF6600">如果插件生成时出现问题,可开启调试模式查看错误信息,方便排除问题原因.</p>		
		<p><input type="submit" value="保存设置" /></p>
	</form>
</div>
<script>
$().ready(function() {
	$('#time').change(function() {
		window.location.href = window.location.href.replace(/&interval=(\d+)/, '')+'&interval='+$('#time').val();
	});
});
</script>