<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
if (!function_exists('_g')) {
	emMsg('请先安装<a href="https://github.com/Baiqiang/em_tpl_options" target="_blank">模板设置插件</a>', BLOG_URL . 'admin/plugins.php');
}
?>
<?php
//widget：blogger
function widget_blogger($title){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\" class='upp'>".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	 <aside id="zan_author-4">    <div class="zan-author text-center hidden-xs">
        <div class="author-top"></div>
        <div class="author-bottom">
        	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
          <img alt='' src='<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>' class='avatar avatar-120 photo' height='120' width='120' /> 
          	<?php endif;?>
         <div class="author-content">
            <span class="author-name"><?php echo $name; ?></span>
            <span class="author-social">
              <div class="btn-group btn-group-justified">
                <?php echo $user_cache[1]['des']; ?>
              </div>
            </span>
          </div>
        </div>
    </div>
    </aside>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
	 <aside id="zan_posts_category-3">
     <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
	<div id="calendar">
	</div>
	<script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
	 </div>
    </aside>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');?>
	<aside id="zan_posts_category-3">
          <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <ul class="zoo-list">
		<?php 
		shuffle ($tag_cache);
		 $tag_cache = array_slice($tag_cache,0,43);
		foreach($tag_cache as $value): ?>
        <li class="btn btn-small"><a  href="<?php echo Url::tag($value['tagurl']); ?>"  class="tag-link-<?php echo rand(12, 49) ?>" style="font-size: 14px;"><?php echo $value['tagname']; ?>(<?php echo $value['usenum']; ?>)</a></li><?php endforeach; ?>
        </ul>
         </div>
    </aside>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $CACHE;
	$sort_cache = $CACHE->readCache('sort'); ?>
    <aside id="zan_posts_category-1">
    <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="list-group zan-category">
	<?php foreach($sort_cache as $value):if ($value['pid'] != 0) continue;?><a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a><?php endforeach; ?>
    </div>
      </div>
    </aside>
<?php }?>
<?php
//widget：最新微语
function widget_twitter($title){
	global $CACHE; 
	$newtws_cache = $CACHE->readCache('newtw');
	$istwitter = Option::get('istwitter');
	
	?>
<aside id="zan_hotest_posts-2">
  <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="panel-body">
          <ul class="list-group">
    <?php foreach($newtws_cache as $value):?>
    <li class="zan-list clearfix">
    <a class="ds-excerpt"><?php echo $value['t']; ?><?php echo $img;?></a>
    </li>
    <?php endforeach; ?>
    </ul>
        </div>
      </div>
</aside>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $CACHE;
	$com_cache = $CACHE->readCache('comment');
	?>
		<aside id="zan_latest_comments-4">
        <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="panel-body">
          <ul class="list-group">
		<?php
		foreach($com_cache as $value):
		$articleUrl = Url::log($value['gid']);
		$url = Url::comment($value['gid'], $value['page'], $value['cid']);
		$db = MySql::getInstance();
		$sql = "SELECT title FROM ".DB_PREFIX."blog WHERE gid=".$value['gid'];
		$ret = $db->query($sql);
		$row = $db->fetch_array($ret);
		$articleTitle = $row['title'];
		$db = MySql::getInstance();
		$sql = "SELECT url FROM ".DB_PREFIX."comment WHERE cid=".$value['cid'];
		$ret = $db->query($sql);
		$row = $db->fetch_array($ret);
		$value['content']=preg_replace("/{smile:(([1-4]?[0-9])|50)}/",'<img class="lazy" src="' . TEMPLATE_URL. 'ui/images/smilies/$1.gif" />',$value['content'])
		?>
		<li class="zan-list clearfix">
                <div class="sidebar-avatar">
			<img src="<?php echo getGravatar($value['mail'], 35); ?>" class='avatar avatar-75 photo' height='75' width='75'/>
            </div>
			<h6>发表于：<a href="<?php echo $articleUrl; ?>"><?php echo $articleTitle; ?></a></h6>
                <div class="sidebar-comment">
			<a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a>
		</div>
              </li>
		<?php endforeach; ?>
		</ul>
	</div>
      </div>
    </aside>
<?php }?>
<?php
//widget：最新文章
function widget_newlog($title){
	global $CACHE; 
	$newLogs_cache = $CACHE->readCache('newlog');
	?>
    <aside id="zan_hotest_posts-2"> 
      <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="panel-body">
          <ul class="list-group">
	<?php foreach($newLogs_cache as $value): ?> 
    <li class="zan-list clearfix">
    <a href="<?php echo Url::log($value['gid']); ?>" title="<?php echo $value['title']; ?>"><?php echo mb_substr($value['title'],0,50,'utf8');?></a></li><?php endforeach; ?>
    </ul>
        </div>
      </div>
    </aside>
<?php }?>
<?php
//widget：热门文章
function widget_hotlog($title){
	$index_hotlognum = Option::get('index_hotlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getHotLog($index_hotlognum);?>
<aside id="zan_hotest_posts-3">
<div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="panel-body">
          <ul class="list-group">
<?php foreach($randLogs as $value): ?>
<li class="zan-list clearfix"><a href="<?php echo Url::log($value['gid']); ?>" title="<?php echo $value['title']; ?>"><?php echo mb_substr($value['title'],0,50,'utf8');?></a></li><?php endforeach; ?>
</ul>
</div>
 </div>
</aside>	
<?php }?>
<?php
//widget：随机文章
function widget_random_log($title){
	$index_randlognum = Option::get('index_randlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getRandLog($index_randlognum);?>
	<aside id="zan_hotest_posts-3">
<div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="panel-body">
          <ul class="list-group">
		  <?php foreach($randLogs as $value): ?>
          <li class="zan-list clearfix"><a href="<?php echo Url::log($value['gid']); ?>" title="<?php echo $value['title']; ?>"><?php echo mb_substr($value['title'],0,50,'utf8');?></a></li><?php endforeach; ?>
</ul>
</div>
 </div>
</aside>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
       <aside id="zan_search-5">
        <form method="get" id="searchform" class="form-inline clearfix hidden-xs" action="<?php echo BLOG_URL; ?>index.php">
        <input class="form-control" type="text" name="keyword" id="s" placeholder="搜索关键词..." />
        <button class="btn btn-zan-solid-pi btn-small"><i class="fa fa-search"></i> 查找</button>
      </form>
    </aside>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	?>
	<aside id="zan_posts_category-2">
          <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="list-group zan-category">
		<?php foreach($record_cache as $value): ?><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a><?php endforeach; ?>
    </div>
      </div>
    </aside>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){?>
	<aside id="zan_latest_comments-4">
          <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="list-group zan-category">
	<?php echo $content; ?>
	</div>
    </div>
    </aside>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
    //if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
	?>
	<aside id="zan_posts_category-`">      <div class="panel panel-zan hidden-xs">
        <div class="panel-heading"><?php echo $title; ?></div>
        <div class="list-group zan-category">
	<?php foreach($link_cache as $value): ?>
	<a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a>
	<?php endforeach; ?>
	</div>
      </div>
    </aside>
<?php }?> 
<?php
//blog：导航
function blog_navi(){
	global $CACHE; 
	$navi_cache = $CACHE->readCache('navi');
	?>
<?php
	foreach($navi_cache as $value):

        if ($value['pid'] != 0) {
            continue;
        }

		if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
			?>
            <li id="menu-item" class="menu-item menu-item-type-taxonomy menu-item-object-category"><a href="<?php echo BLOG_URL; ?>admin"><i class="fa fa-cog"></i> 管理</a>
    <ul class="dropdown-menu">
	 <li  class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo BLOG_URL; ?>admin/comment.php">评论</a></li>
     <li  class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo BLOG_URL; ?>admin/write_log.php">发表</a></li>
     <li  class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
</ul>
    
    </li>
	
	<?php 
			continue;
		endif;
		$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
        $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/'); $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current-menu-item current_page_item' : '';?><li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page  <?php echo $current_tab;?>">
<a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>>
<?php if($value['naviname'] == "首页"):?><i class="fa fa-home"></i>
<?php elseif($value['naviname'] =="微语"):?><i class="fa  fa-coffee"></i>
<?php elseif($value['naviname'] =="相册"):?><i class="fa fa-camera"></i>
<?php elseif($value['naviname'] =="归档"):?><i class="fa  fa-th-list"></i>
<?php elseif($value['naviname'] =="留言" || $value['naviname'] =="留言板"):?><i class="fa fa-comments"></i>
<?php elseif($value['naviname'] =="读者排行" || $value['naviname'] =="读者墙"):?><i class="fa fa-windows"></i>
<?php elseif($value['naviname'] =="登录"):?><i class="fa fa-cogs"></i>
<?php elseif($value['naviname'] =="投稿"):?><i class="fa fa-share-alt"></i>
<?php elseif($value['naviname'] =="手机版"):?><i class="fa fa-mobile"></i>
<?php else:?><i class="fa fa-book"></i>
<?php endif;?> <?php echo $value['naviname']; ?>
</a>
<?php if (!empty($value['children'])) :?>
            <ul class="dropdown-menu">
                <?php foreach ($value['children'] as $row){
                        echo '<li  class="menu-item menu-item-type-post_type menu-item-object-page"><a href="'.Url::sort($row['sid']).'">'.$row['sortname'].'</a></li>';
                }?>
			</ul>
            <?php endif;?>

            <?php if (!empty($value['childnavi'])) :?>
            <ul class="dropdown-menu">
                <?php foreach ($value['childnavi'] as $row){
                        $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                        echo '<li  class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . $row['url'] . "\" $newtab >" . $row['naviname'].'</a></li>';
                }?>
			</ul>
            <?php endif;?>
            </li>
<?php endforeach; ?>
<li id="menu-item" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php sbkk_logs();?>"><i class="fa   fa-hand-o-right"></i> 随便看看</a></li>
<?php }?>
<?php
//blog：置顶
function topflg($top, $sortop='n', $sortid=null){
    if(blog_tool_ishome()) {
       echo $top == 'y' ? "<img src=\"".TEMPLATE_URL."/images/top.png\" title=\"首页置顶文章\" /> " : '';
    } elseif($sortid){
       echo $sortop == 'y' ? "<img src=\"".TEMPLATE_URL."/images/sortop.png\" title=\"分类置顶文章\" /> " : '';
    }
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == 'admin' || $author == UID ? '<span class="label label-zan"><i class="fa fa-edit"></i> <a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" class="post-edit-link" target="_blank">编辑</a></span>' : '';
	echo $editflg;
}
?>
<?php
//blog：分类
function blog_sort($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if(!empty($log_cache_sort[$blogid])): ?>
    <a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>" rel="category tag"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
	<?php endif;?>
<?php }?>
<?php
//blog：日志标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '继续浏览有关 ';
		foreach ($log_cache_tags[$blogid] as $key=>$value){
			$tag .= "<a href=\"".Url::tag($value['tagurl'])."\" class=\"tag".$key."\">".$value['tagname'].'</a>';
		}
		echo $tag.' 的文章';
	}else {
		echo '此文暂无标签';
	}
}
?>
<?php
//blog：文章作者
function blog_author($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo '<a href="'.Url::author($uid)."\" class='upp' $title>$author</a>";
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
	extract($neighborLog);?>
	<?php if($prevLog):?>
	<li class="previous"><a href="<?php echo Url::log($prevLog['gid']) ?>" title="<?php echo $prevLog['title'];?>">上一篇</a></li>
	<?php endif;?>
	
	<?php if($nextLog):?>
		<li class="next"> <a href="<?php echo Url::log($nextLog['gid']) ?>" title="<?php echo $nextLog['title'];?>">下一篇</a></li>
	<?php endif;?>
<?php }?>
<?php
//blog：评论列表
function blog_comments($comments,$comnum){
    extract($comments);
    if($commentStacks): ?>
	<a name="comments" class="comment-top"></a>
<h3 id="comments-title" class="comments-header"><i class="fa fa-comments"></i> <?php echo $comnum;?> 条评论</h3>
        <div id="loading-comments"><i class="fa fa-spinner fa-spin"></i></div>
	<?php endif; ?>
     <ol class="commentlist">
	<?php
	$isGravatar = Option::get('isgravatar');
	foreach($commentStacks as $cid):
    $comment = $comments[$cid];
	$comment['content'] = preg_replace("/{smile:(([1-4]?[0-9])|50)}/",'<img src="' . TEMPLATE_URL. 'ui/images/smilies/$1.gif" />',$comment['content']);
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank" class="upps">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<a name="<?php echo $comment['cid']; ?>"></a>
        <li id="comment-<?php echo $comment['cid']; ?>" class="comment byuser comment-author-qxk6 odd alt thread-odd thread-alt depth-1">
			<article id="div-comment-<?php echo $comment['cid']; ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if($isGravatar == 'y'): ?><img alt="" src="<?php echo getGravatar($comment['mail']); ?>" class="avatar avatar-70 wp-user-avatar wp-user-avatar-70 alignnone photo" height="70" width="70"><?php endif; ?>


                        <b class="fn"><?php echo $comment['poster']; ?></b><span class="says"> 说道：</span></div><!-- .comment-author -->

					<div class="comment-metadata">
						<a>
							<time datetime="<?php echo $comment['date']; ?>">
								<?php echo $comment['date']; ?>							</time>
						</a>
											</div><!-- .comment-metadata -->

									</footer><!-- .comment-meta -->

				<div class="comment-content">
					<p><?php echo $comment['content']; ?></p>
				</div><!-- .comment-content -->

				<div class="reply">
					<a  class="comment-reply-login" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a>				</div><!-- .reply -->
			</article><!-- .comment-body -->

		<?php blog_comments_children($comments, $comment['children']); ?>
	</li>
	<?php endforeach; ?>
    </ol>
	<?php if($commentPageUrl) {?><br />
<div id="zan-page" class="clearfix">
	<ul class="pagination pagination-zan pull-right">	    <?php echo $commentPageUrl;?>
    </ul>
</div>
	<?php } ?>
<?php }?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children){
	$isGravatar = Option::get('isgravatar');
	foreach($children as $child) {
	$comment = $comments[$child];
	$comment['content'] = preg_replace("/{smile:(([1-4]?[0-9])|50)}/",'<img src="' . TEMPLATE_URL. 'ui/images/smilies/$1.gif" />',$comment['content']);
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank" class="upps">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<ol class="children">
		<a name="<?php echo $comment['cid']; ?>"></a>
        <li id="comment-<?php echo $comment['cid']; ?>" class="comment byuser comment-author-benz odd alt depth-2">
			<article id="div-comment" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
                    		<?php if($isGravatar == 'y'): ?>
                            <img alt='' src='<?php echo getGravatar($comment['mail']); ?>' class='avatar avatar-70 wp-user-avatar wp-user-avatar-70 alignnone photo' height='70' width='70' /><?php endif; ?>
                          <b class="fn"><?php echo $comment['poster']; ?></b><span class="says"> 说道：</span>					</div><!-- .comment-author -->
<div class="comment-metadata">
						<a>
							<time datetime="<?php echo $comment['date']; ?>">
								<?php echo $comment['date']; ?>9							</time>
						</a>
											</div><!-- .comment-metadata -->
									</footer><!-- .comment-meta -->

				<div class="comment-content">
					<p><?php echo $comment['content']; ?></p>
				</div><!-- .comment-content -->

				<div class="reply">
					<a class="comment-reply-login" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a>				</div><!-- .reply -->
			</article><!-- .comment-body -->
</li><!-- #comment-## -->
		<?php blog_comments_children($comments, $comment['children']);?>
</ol><!-- .children -->
	<?php } ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'): ?>
<div id="comment-place">
	<div class="comment-post" id="comment-post">
		<h3 id="reply-title" class="comment-reply-title"><i class="fa fa-pencil"></i> 欢迎留言 <small><a name="respond"></a><span class="cancel-reply" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()" id="cancel-comment-reply-link" >取消</a></span></small></h3>
		<form action="<?php echo BLOG_URL; ?>index.php?action=addcom" method="post" id="commentform" class="comment-form">
									<div id="commentform-error" class="alert hidden"></div>	
                                    			<?php if(ROLE == 'visitor'): ?>
                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" name="comname" id="author" placeholder="* 昵称" value="<?php echo $ckname; ?>"></div>
<div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope-o"></i></span><input type="text" name="commail" id="email" placeholder="* 邮箱" value="<?php echo $ckmail; ?>"></div>
<div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span><input type="text" name="comurl" id="url" placeholder="网站" value="<?php echo $ckurl; ?>" ></div>
<?php else:
          $CACHE = Cache::getInstance();
	       $user_cache = $CACHE->readCache('user');
        ?>
        <p class="logged-in-as">已经登录。<a href="<?php echo BLOG_URL; ?>admin/?action=logout" title="登出此帐户">登出？</a></p>	
		<?php endif; ?>
      <?php include View::getView('smiley');?>
	<textarea id="comment" placeholder="赶快发表你的见解吧！" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                                <?php echo $verifyCode; ?>
                                                						<p class="form-submit">
							<input name="submit" type="submit" id="submit" value="发表评论" />
										<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
			<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>

						</p>
											</form>
	</div>
	</div>
	<?php endif; ?>
    <?php }?>

<?php
//blog-tool:判断是否是首页
function blog_tool_ishome(){
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){
        return true;
    } else {
        return FALSE;
    }
}
?>

<?php
//获取附件第一张图片
function getThumbnail($blogid){
    $db = MySql::getInstance();
    $sql = "SELECT * FROM ".DB_PREFIX."attachment WHERE blogid=".$blogid." AND (`filepath` LIKE '%jpg' OR `filepath` LIKE '%gif' OR `filepath` LIKE '%png') ORDER BY `aid` ASC LIMIT 0,1";
    //die($sql);
    $imgs = $db->query($sql);
    $img_path = "";
    while($row = $db->fetch_array($imgs)){
         $img_path .= $row['filepath'];
    }
    return $img_path;
}
?>
<?php
function handlearticledes($des) {
	$str = preg_replace("/(<\/?)(\w+)([^>]*>)/e",'',$des);
	$str = preg_replace("/阅读全文&gt;&gt;/",'',$str);
	$str = strip_tags($str,""); 
    $str = ereg_replace("\t","",$str); 
    $str = ereg_replace("\r\n","",$str); 
    $str = ereg_replace("\r","",$str); 
    $str = ereg_replace("\n","",$str); 
    $str = ereg_replace(" "," ",$str); 
	return mb_substr($str,0,200,'utf8').'...';
}
?>
<?php
function index_t(){
	$t = MySql::getInstance();
	?>
	<?php
	$sql = "SELECT id,content,img,author,date,replynum FROM ".DB_PREFIX."twitter ORDER BY `date` DESC LIMIT 1";
	$list = $t->query($sql);
	while($row = $t->fetch_array($list)){
	?>
	<h2><a href="<?php echo BLOG_URL; ?>t" rel="bookmark"><i class="icon-eject icon-large"></i><?php echo $row['content'];?></a><span><?php echo gmdate('m月d日,Y', $row['date']); ?></span></h2>
<?php }?>
<?php } ?>
<?php
	function related_logs($logData = array())
	{
	$configfile = EMLOG_ROOT.'/content/templates/zanblog3/config.php';
	if (is_file($configfile)) {
	require $configfile;
	}else{
	    $related_log_type = 'sort';//相关日志类型，sort为分类，tag为日志；
	    $related_log_sort = 'rand';//排列方式，views_desc 为点击数（降序）comnum_desc 为评论数（降序） rand 为随机 views_asc 为点击数（升序）comnum_asc 为评论数（升序）
	    $related_log_num = '10'; //显示文章数，排版需要，只能为10
	    $related_inrss = 'y'; //是否显示在rss订阅中，y为是，其它值为否
	    }
	    global $value;
	    $DB = MySql::getInstance();
	    $CACHE = Cache::getInstance();
	    extract($logData);
	    if($value)
	    {
	        $logid = $value['id'];
	        $sortid = $value['sortid'];
	        global $abstract;
	    }
	    $sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' AND type='blog'";
	    if($related_log_type == 'tag')
	    {
	        $log_cache_tags = $CACHE->readCache('logtags');
	        $Tag_Model = new Tag_Model();
	        $related_log_id_str = '0';
	        foreach($log_cache_tags[$logid] as $key => $val)
	        {
	            $related_log_id_str .= ','.$Tag_Model->getTagByName($val['tagname']);
	        }
	        $sql .= " AND gid!=$logid AND gid IN ($related_log_id_str)";
	    }else{
	        $sql .= " AND gid!=$logid AND sortid=$sortid";
	    }
	    switch ($related_log_sort)
	    {
	        case 'views_desc':
	        {
	            $sql .= " ORDER BY views DESC";
	            break;
	        }
	        case 'views_asc':
			{
	            $sql .= " ORDER BY views ASC";
	            break;
	        }
	        case 'comnum_desc':
	        {
	            $sql .= " ORDER BY comnum DESC";
	            break;
	        }
	        case 'comnum_asc':
	        {
	            $sql .= " ORDER BY comnum ASC";
	            break;
	        }
	        case 'rand':
	        {
	            $sql .= " ORDER BY rand()";
	            break;
	        }
	    }
	    $sql .= " LIMIT 0,$related_log_num";
	    $related_logs = array();
	    $query = $DB->query($sql);
	    while($row = $DB->fetch_array($query))
	    {
	        $row['gid'] = intval($row['gid']);
	        $row['title'] = htmlspecialchars($row['title']);
	        $related_logs[] = $row;
	    }
	    $out = '';
	    if(!empty($related_logs))
	    {
	        foreach($related_logs as $val)
	        {
	            $out .= "<li><a href=\"".Url::log($val['gid'])."\">{$val['title']}</a></li>";
	        }
	    }
	    if(!empty($value['content']))
	    {
	        if($related_inrss == 'y')
	        {
	            $abstract .= $out;
	        }
	    }else{
	        echo $out;
	    }
	}	 
?>
<?php
function indexLogList($num=3){
	$Log_Model = new Log_Model();
	$time = time();
	$randLogs = $Log_Model-> getLogsForHome(" ORDER BY date DESC",1,$num);
	$i=1;
	foreach($randLogs as $value):
		?>
<li><a href="<?php echo $value[log_url];?>">
<div class="slide-text hidden-xs"><?php echo $value['log_title'] ?></div>
<?php $thum_src = getThumbnail($value['logid']);$imgFileArray = glob("content/templates/zanblog3/ui/random/*.*");$imgsrc = preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $value['content'], $img);$imgsrc = !empty($img[1]) ? $img[1][0] : ''; ?>
      <?php if ($imgcache == "yes"): ?>
<?php if ($thum_src):?> 
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo $thum_src; ?>&h=450&w=750&zc=1" alt="<?php echo $value['log_title'] ?>" class="attachment-post-thumbnail wp-post-image" alt="banner_<?php echo $i?>"/>
<?php elseif($imgsrc): ?>
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo $imgsrc; ?>&h=450&w=750&zc=1" alt="<?php echo $value['log_title'] ?>" class="attachment-post-thumbnail wp-post-image" alt="banner_<?php echo $i?>"/>
<?php else: ?>
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo BLOG_URL; ?><?php echo $imgFileArray[array_rand($imgFileArray)]; ?>&h=450&w=750&zc=1"  class="attachment-post-thumbnail wp-post-image" alt="banner_<?php echo $i?>"/>
<?php endif; ?>
 <?php else:?>
 <?php if ($thum_src):?> 
<img src="<?php echo $thum_src; ?>" alt="<?php echo $value['log_title'] ?>" class="attachment-post-thumbnail wp-post-image" alt="banner_<?php echo $i?>"/>
<?php elseif($imgsrc): ?>
<img src="<?php echo $imgsrc; ?>" alt="<?php echo $value['log_title'] ?>" class="attachment-post-thumbnail wp-post-image" alt="banner_<?php echo $i?>"/>
<?php else: ?>
<img src="<?php echo BLOG_URL; ?><?php echo $imgFileArray[array_rand($imgFileArray)]; ?>"  class="attachment-post-thumbnail wp-post-image" alt="banner_<?php echo $i?>"/>
<?php endif; ?>
<?php endif; ?>
</a>
</li>
		<?php
	endforeach;$i=$i++;
}
?>


<?php
function timer_start() {
  global $timestart;
  $mtime = explode( ' ', microtime() );
  $timestart = $mtime[1] + $mtime[0];
  return true;
}
timer_start();
 
function timer_stop( $display = 0, $precision = 3 ) {
  global $timestart, $timeend;
  $mtime = explode( ' ', microtime() );
  $timeend = $mtime[1] + $mtime[0];
  $timetotal = $timeend - $timestart;
  $r = number_format( $timetotal, $precision );
  if ( $display )
    echo $r;
  return $r;
}
?>

<?php
//文章关键词
function log_key_words($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .="".$value['tagname'].',';
		}
		echo substr($tag,0,-1);
	}
}
?>

<?php
//随便看看
function sbkk_logs() {
$db = MySql::getInstance();
$sql = "SELECT gid FROM ".DB_PREFIX."blog WHERE type='blog' and hide='n' ORDER BY rand() LIMIT 0,1";
$sbkk_logs_list = $db->query($sql);
while($row = $db->fetch_array($sbkk_logs_list)){ 
echo Url::log($row['gid']);}
}?>
