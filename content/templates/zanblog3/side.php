<?php 
/**
 * 侧边栏
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<aside class="col-md-4" id="sidebar">
<?php if ($dengru == "yes"): ?>
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<aside id="zan_login-2">
<div class="panel panel-zan">
      <div class="panel-heading"><i class="fa fa-quote-left"></i> 欢迎！ <i class="fa fa-quote-right"></i></div>
      <div class="login-panel text-center">
<?php global $CACHE;$user_cache = $CACHE->readCache('user');$name = $user_cache[UID]['name'];$user_cache[$author]['mail']; ?><?php if($user_cache[$author]['photo']['src']):?>
<?php if (!empty($user_cache[$author]['photo']['src'])): ?>
<img src="<?php echo BLOG_URL.$user_cache[$author]['photo']['src']; ?>" class="avatar avatar-60 photo" height="60" width="60">
<?php endif; ?>
<?php else:?>
<img src="<?php echo getGravatar($user_cache[UID]['mail']); ?>" class="avatar avatar-60 photo" height="60" width="60">
<?php endif; ?>
           <a class="user-name" href="<?php echo BLOG_URL; ?>admin"><?php echo $name;?></a>
          <a class="btn btn-zan-solid-pw" href="<?php echo BLOG_URL; ?>admin/?action=logout" title="退出登录">退出登录</a>
      </div>
</div>
</aside>
<?php else:?>
    <aside id="zan_login-2">
    <div class="panel panel-zan">
      <div class="panel-heading">请登录</div>
      <form class="login-form clearfix" action="<?php echo BLOG_URL; ?>admin/index.php?action=login" method="post" name="f">
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <input class="form-control" type="text" name="user" id="user" value="" size="20" />
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
            <input class="form-control" type="password" name="pw" id="pw" size="20" />
          </div>
        </div>
        <button class="btn btn-zan-solid-ip pull-left"  type="submit">登录</button>
        <a href="<?php echo BLOG_URL; ?>?plugin=yls_reg" class="btn btn-zan-solid-ip pull-right">注册</a>
      </form>
    </div>
        </aside>
 <?php endif; ?>
 <?php else:?> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<aside id="zan_login-2">
<div class="panel panel-zan">
      <div class="panel-heading"><i class="fa fa-quote-left"></i> 欢迎！ <i class="fa fa-quote-right"></i></div>
      <div class="login-panel text-center">
<?php global $CACHE;$user_cache = $CACHE->readCache('user');$name = $user_cache[UID]['name'];$user_cache[$author]['mail']; ?><?php if($user_cache[$author]['photo']['src']):?>
<?php if (!empty($user_cache[$author]['photo']['src'])): ?>
<img src="<?php echo BLOG_URL.$user_cache[$author]['photo']['src']; ?>" class="avatar avatar-60 photo" height="60" width="60">
<?php endif; ?>
<?php else:?>
<img src="<?php echo getGravatar($user_cache[UID]['mail']); ?>" class="avatar avatar-60 photo" height="60" width="60">
<?php endif; ?>
           <a class="user-name" href="<?php echo BLOG_URL; ?>admin"><?php echo $name;?></a>
          <a class="btn btn-zan-solid-pw" href="<?php echo BLOG_URL; ?>admin/?action=logout" title="退出登录">退出登录</a>
      </div>
</div>
</aside>
 <?php endif; ?>
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
<aside id="zan_latest_comments-4">
<div class="panel panel-zan hidden-xs">
<div class="panel-heading">站点统计</div> <?php $sta_cache = Cache::getInstance()->readCache('sta');?>        <div id="list-total">
<li>文章总数：<?php echo $sta_cache['lognum']; ?>篇</li><li>微语总数：<?php echo $sta_cache['twnum']; ?>条</li><li>评论总数：<?php echo $sta_cache['comnum']; ?>条</li><li>网站运行：<?php echo floor((time()-strtotime(_g('opentime')))/86400); ?>天</li>
</div>
</div>
</aside>
<?php if ($bofa == "yes"): ?>
<aside id="zan_audio-2">
<div class="panel panel-zan hidden-xs">
      <div class="panel-heading">音乐盒</div>
      <audio src="<?php echo _g('mp3'); ?>" type="audio/mpeg" preload="auto"></audio>
</div>
</aside>
<?php else: ?>
<?php endif; ?>
</aside>
</div>
</section>