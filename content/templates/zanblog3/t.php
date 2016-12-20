<?php 
/**
 * 微语部分
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="zan-bodyer">
	<div class="container">
		<section class="row">
			<div class="col-md-8">
  			<article class="zan-article">
					<!-- 面包屑 -->
					<div class="breadcrumb">
					    <i class="fa fa-map-marker"></i>
<a title="Go to index." href="<?php echo BLOG_URL; ?>" class="home">首页</a> / 微语</div>
<div style="margin-top:10px;text-align:center;">不同的心情，不同的记录</div>
</article>
<div id="comments-template">
  <div class="comments-wrap">
    <div id="comments">
    <ol class="commentlist">
    <?php 
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
//增加兼容sae的代码
	if(strpos($user_cache[$val['author']]['avatar'],'stor.sinaapp.com')!==false) $tmpurl='';else $tmpurl = BLOG_URL;
    $avatar = empty($user_cache[$val['author']]['avatar']) ? 
                BLOG_URL . 'admin/views/images/avatar.jpg' : 
                $tmpurl.$user_cache[$val['author']]['avatar'];
    $tid = (int)$val['id'];
    $img = empty($val['img']) ? "" : '<a title="查看图片" href="'.BLOG_URL.str_replace('thum-', '', $val['img']).'" target="_blank"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$val['img'].'"/></a>';
    ?> 
 <li id="comment" class="comment byuser comment-author-qxk6 odd alt thread-odd thread-alt depth-1">
			<article id="div-comment" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<img alt="" src="<?php echo $avatar; ?>" class="avatar avatar-70 wp-user-avatar wp-user-avatar-70 alignnone photo" height="70" width="70">
                        						<b class="fn"><?php echo $author; ?></b><span class="says"> 说道：</span>					</div><!-- .comment-author -->
					<div class="comment-metadata">
							<time datetime="<?php echo $val['date'];?>">
								<?php echo $val['date'];?>							</time>
											</div><!-- .comment-metadata -->
									</footer><!-- .comment-meta -->
				<div class="comment-content">
					<p><?php echo $val['t'].'<br/>'.$img;?></p>
				</div><!-- .comment-content -->
                <div class="reply">
					<a class="comment-reply-login" href="javascript:loadr('<?php echo DYNAMIC_BLOGURL; ?>?action=getr&tid=<?php echo $tid;?>','<?php echo $tid;?>');">回复</a></div>
                       <ol class="children">
			<article id="div-comment" class="comment-body">
                        <ul id="r_<?php echo $tid;?>" class="r"></ul>
                        </article>
</ol>
                <?php if ($istreply == 'y'):?>
    <div class="addcomment">
    <div class="huifu" id="rp_<?php echo $tid;?>">
    <div class="comt">
			<div class="comt-box">
	<textarea  placeholder="其实，你的评论很给力！" class="input-block-level comt-area rtext" name="comment" id="rtext_<?php echo $tid; ?>" cols="100%" rows="3" tabindex="1"></textarea>
    </div></div>
   <div class="comt-comterinfo" id="comment-author-info" style="display:<?php if(ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER){echo 'none';}?>">
        <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" id="rname_<?php echo $tid; ?>" id="author" placeholder="* 昵称"></div>
        <span style="display:<?php if($reply_code == 'n'){echo 'none';}?>">验证码：<input type="text" id="rcode_<?php echo $tid; ?>" value="" /><?php echo $rcode; ?></span>
        </div>
         <button id="submit" type="button" onclick="reply('<?php echo DYNAMIC_BLOGURL; ?>index.php?action=reply',<?php echo $tid;?>);" value="回复" /> 回复</button>
        <div class="msg"><span id="rmsg_<?php echo $tid; ?>" style="color:#FF0000"></span></div>
    </div>
    </div>
    <?php endif;?>
                </article><!-- .comment-body -->
            </li>
    <?php endforeach;?>
    <br />
	<div id="zan-page" class="clearfix">
	<ul class="pagination pagination-zan pull-right"><?php echo $pageurl;?></ul></div>
    </ol>
    </div>
    </div>
</div></div>
<?php
 include View::getView('eside');
 include View::getView('footer');
?>