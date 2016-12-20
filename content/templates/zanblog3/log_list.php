<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<section id="zan-bodyer">
	<div class="container">
		<section class="row">
			<section class="col-md-8" id="mainstay">
             <?php if (blog_tool_ishome()) :?>
            <?php if ($homeside == "yes"): ?>
            <?php if ($news_img == "yes"): ?>
        <aside id="zan_slide-3">
        <div class="flexslider hidden-xs">
      <ul class="slides">
          <?php echo  indexLogList();?>
            </ul>
    </div>
    </aside>
   <?php else:?>
<aside id="zan_slide-3">
        <div class="flexslider hidden-xs">
      <ul class="slides">
      <?php if ($imgcache == "yes"): ?>
<li><a href="<?php echo _g('imgaddress'); ?>">
<div class="slide-text hidden-xs"><?php echo _g('imgname'); ?></div>
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo _g('focusimg'); ?>&h=450&w=750&zc=1"  class="attachment-post-thumbnail wp-post-image" alt="banner_1"/>
</a>
</li> 
<li><a href="<?php echo _g('imgaddress2'); ?>">
<div class="slide-text hidden-xs"><?php echo _g('imgname2'); ?></div>
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo _g('focusimg2'); ?>&h=450&w=750&zc=1"  class="attachment-post-thumbnail wp-post-image" alt="banner_2"/>
</a>
</li>
<li><a href="<?php echo _g('imgaddress3'); ?>">
<div class="slide-text hidden-xs"><?php echo _g('imgname3'); ?></div>
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo _g('focusimg3'); ?>&h=450&w=750&zc=1"  class="attachment-post-thumbnail wp-post-image" alt="banner_3"/>
</a>
</li>
 <?php else:?>
 <?php if(_g('imgaddress')){?>
 <li><a href="<?php echo _g('imgaddress'); ?>">
<div class="slide-text hidden-xs"><?php echo _g('imgname'); ?></div>
<img src="<?php echo _g('focusimg'); ?>"  class="attachment-post-thumbnail wp-post-image" alt="banner_1"/>
</a>
</li> 
<?php }else{?><?php }?>
<?php if(_g('imgaddress2')){?>
<li><a href="<?php echo _g('imgaddress2'); ?>">
<div class="slide-text hidden-xs"><?php echo _g('imgname2'); ?></div>
<img src="<?php echo _g('focusimg2'); ?>"  class="attachment-post-thumbnail wp-post-image" alt="banner_2"/>
</a>
</li>
<?php }else{?><?php }?>
<?php if(_g('imgaddress3')){?>
<li><a href="<?php echo _g('imgaddress3'); ?>">
<div class="slide-text hidden-xs"><?php echo _g('imgname3'); ?></div>
<img src="<?php echo _g('focusimg3'); ?>"  class="attachment-post-thumbnail wp-post-image" alt="banner_3"/>
</a>
</li>
<?php }else{?><?php }?>
<?php endif; ?>
    </ul>
    </div>
    </aside>
<?php endif; ?>
 <?php else:?>
<?php endif; ?>
 <?php else:?>
<?php endif; ?>
<?php doAction('index_loglist_top'); ?>
<?php if ($note == "yes"): ?>
<div class="top_box">
          <div class="top_post">
      <div class="title">公  告</div>
      <article class="ulist">
      <?php index_t();?>
    </article>
    </div>
</div>
<?php else:?>
<?php endif; ?>
<?php 
if (!empty($logs)):
foreach($logs as $value): 
?>                
<div class="article zan-post clearfix">
            <i class="fa fa-bookmark article-stick"></i>  					<!-- PC端设备文章显示 -->
  					<section class="visible-md visible-lg">
              <span class="label label-zan"><?php blog_sort($value['logid']); ?></span>
  						<h3>
  							<a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a>
  						</h3>
  						<hr>
                            <div class="row">
                <div class="col-md-5">
      			<figure class="thumbnail zan-thumb">
                <a href="<?php echo $value['log_url']; ?>">
                <?php $thum_src = getThumbnail($value['logid']);$imgFileArray = glob("content/templates/zanblog3/ui/random/*.*");$imgsrc = preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $value['content'], $img);$imgsrc = !empty($img[1]) ? $img[1][0] : ''; ?>
<?php if ($imgcache == "yes"): ?>
<?php if ($thum_src):?> 
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo $thum_src; ?>&h=180&w=300&zc=1" class="attachment-300x180 wp-post-image" alt=""/>  
<?php elseif($imgsrc): ?>
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo $imgsrc; ?>&h=180&w=300&zc=1" class="attachment-300x180 wp-post-image" alt=""/>  
<?php else: ?>
<img src="<?php echo TEMPLATE_URL; ?>timthumb.php?src=<?php echo BLOG_URL; ?><?php echo $imgFileArray[array_rand($imgFileArray)]; ?>&h=180&w=300&zc=1" class="attachment-300x180 wp-post-image" alt=""/>  
<?php endif; ?>
<?php else:?>  
<?php if ($thum_src):?> 
<img src="<?php echo $thum_src; ?>" class="attachment-300x180 wp-post-image" alt="" id="imgcache"/>  
<?php elseif($imgsrc): ?>
<img src="<?php echo $imgsrc; ?>" class="attachment-300x180 wp-post-image" alt="" id="imgcache"/>  
<?php else: ?>
<img src="<?php echo BLOG_URL; ?><?php echo $imgFileArray[array_rand($imgFileArray)]; ?>" class="attachment-300x180 wp-post-image" alt="" id="imgcache"/>  
<?php endif; ?>
  <?php endif; ?>
     
</a></figure>	
                </div>						
    						<div class="col-md-7 visible-lg zan-outline">					
    							<?php echo $value['log_description'] = handlearticledes(subString(trim(strip_tags($value['log_description'])), 0,180));?></div>
                <div class="col-md-7 visible-md zan-outline">         
                  <?php echo $value['log_description'] = handlearticledes(subString(trim(strip_tags($value['log_description'])), 0,100));?></div>
              </div>
                            <hr>
  						<div class="pull-right post-info">
  							<span><i class="fa fa-calendar"></i> <?php echo gmdate('m月d日,Y', $value['date']); ?></span>
  							<span><i class="fa fa-user"></i> <?php blog_author($value['author']); ?></span>
  							<span><i class="fa fa-eye"></i> <?php echo $value['views']; ?>人</span>
                <span><i class="fa fa-comment"></i> <?php if($value['comnum']):?><?php echo $value['comnum']; ?>条评论</a><?php else:?>暂无</a><?php endif;?></span>
  						</div>
  					</section>
  					<!-- PC端设备文章显示结束 -->
  					<!-- 移动端设备文章显示 -->
  					<section class="visible-xs  visible-sm">
  						<div class="title-article">
  							<h4><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h4>
  						</div>
  						<p class="post-info">
  							<span><i class="fa fa-calendar"></i> <?php echo gmdate('m月d日,Y', $value['date']); ?></span>
  							<span><i class="fa fa-eye"></i> <?php echo $value['views']; ?>人</span>
  						</p>
  						<div class="content-article">
  							  							<figure class="thumbnail">
                                                        <a href="<?php echo $value['log_url']; ?>">
                <?php $thum_src = getThumbnail($value['logid']);$imgFileArray = glob("content/templates/zanblog3/ui/random/*.*");$imgsrc = preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $value['content'], $img);$imgsrc = !empty($img[1]) ? $img[1][0] : ''; ?>
<?php if ($thum_src):?> 
<img src="<?php echo $thum_src; ?>"  class="attachment-750x450 wp-post-image" alt=""  width="750" height="450"/>
<?php elseif($imgsrc): ?>
<img src="<?php echo $imgsrc; ?>"  class="attachment-750x450 wp-post-image" alt="" width="750" height="450" />
<?php else: ?>
<img src="<?php echo BLOG_URL; ?><?php echo $imgFileArray[array_rand($imgFileArray)]; ?>"  width="750" height="450"  class="attachment-750x450 wp-post-image" alt=""/>
<?php endif; ?>
</a></figure>
                                                        
                                                       					
  							<div class="well">		
<?php echo $value['log_description'] = handlearticledes(subString(trim(strip_tags($value['log_description'])), 0,100));?>							</div>
  						</div>
  						<a class="btn btn-zan-line-pp btn-block" href="<?php echo $value['log_url']; ?>"  title="详细阅读">阅读全文 <span class="badge"><?php echo $value['comnum']; ?></span></a>
  					</section>
  					<!-- 移动端设备文章显示结束 -->
  				</div>
               <?php endforeach;else:?>
	<h2>未找到</h2>
	<p>
		抱歉，没有符合您查询条件的结果。
	</p>
	<?php endif;?> 
         <!-- 分页 -->
        <div id="zan-page" class="clearfix">
	<ul class="pagination pagination-zan pull-right">
    <?php echo $page_url;?>
	 </ul>
</div>
        <!-- 分页结束 -->
</section>
<?php
 include View::getView('side');
 include View::getView('footer');
?>