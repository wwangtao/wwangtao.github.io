<?php 
/**
 * 侧边栏
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<aside class="col-md-4" id="sidebar">
 <?php if (isset($logid) && empty($tws)&&  empty($sortName)&& $log_title !="留言"):?> 
 <aside id="zan_author-4">
     <div class="zan-author text-center hidden-xs">
        <div class="author-top"></div>
        <?php global $CACHE;$user_cache = $CACHE->readCache('user');$name = $user_cache[$author]['mail'] != '' ? "".$user_cache[$author]['name']."" : $user_cache[1]['name'];?>
        <div class="author-bottom">
        <?php if($user_cache[$author]['photo']['src']):?>
		<?php global $CACHE;$user_cache = $CACHE->readCache('user'); if (!empty($user_cache[$author]['photo']['src'])): ?><img src="<?php echo $user_cache[$author]['photo']['src']; ?>" class="avatar avatar-120 photo" height="120" width="120"><?php endif; ?><?php else:?><img src="<?php echo getGravatar($user_cache[$author]['mail']); ?>" class="avatar avatar-120 photo" height="120" width="120">
		<?php endif; ?>
                  <div class="author-content">
            <span class="author-name"><?php blog_author($author); ?></span>
            <span class="author-social">
              <div class="btn-group btn-group-justified">
                <a class="btn btn-zan-solid-wi" target="_blank" href="<?php echo _g('sina'); ?>"><i class="fa fa-weibo"></i> 新浪微博</a>
                <a class="btn btn-zan-solid-wi" target="_blank" href="<?php echo _g('tengxun'); ?>"><i class="fa fa-tencent-weibo"></i> 腾讯微博</a>
              </div>
            </span>
          </div>
        </div>
    </div>

    </aside>
   <?php else:?>
<?php endif; ?>

 <?php 
$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
doAction('diff_side');
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_widget = @unserialize($options_cache['custom_widget']);

	if(strpos($val, 'custom_wg_') === 0)
	{
		$callback = 'widget_custom_text';
		if(function_exists($callback))
		{
			call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content']);
		}
	}else{
		$callback = 'widget_'.$val;
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, htmlspecialchars($wgTitle));
		}
	}
}
?>
</div>
</section>
