<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="zan-bodyer">
	<div class="container">
		<section class="row">
			<div class="col-md-8">
				<!-- 广告 -->
                <!-- 广告结束 -->	
								<article class="zan-article">
					<!-- 面包屑 -->
					<div class="breadcrumb">
					    <i class="fa fa-map-marker"></i> <!-- Breadcrumb NavXT 5.1.0 -->
<a title="Go to index." href="<?php echo BLOG_URL; ?>" class="home">首页</a> / <?php echo $log_title; ?>					</div>
					<!-- 面包屑结束 -->
					<!-- 大型设备文章显示 -->
					<div class="hidden-xs">
						<h1><a href="<?php echo Url::log($logid);?>"><?php echo $log_title; ?>	</a></h1>
						<p class="post-big-info">
	            <span class="label label-zan"><i class="fa fa-calendar"></i> <?php echo gmdate('Y-n-j G:i', $date); ?></span>
							<span class="label label-zan"><i class="fa fa-tags"></i> <?php blog_sort($logid); ?></span>
							<span class="label label-zan"><i class="fa fa-user"></i> <?php blog_author($author); ?></span>
							<span class="label label-zan"><i class="fa fa-eye"></i> <?php echo $views; ?>人</span>
                            <?php editflg($logid,$author); ?>
						</p>
					</div>
					<!-- 大型设备文章显示结束 -->
					<!-- 小型设备文章显示 -->
					<div class="visible-xs">
						<div class="title-article">
							<h4><a href="<?php echo Url::log($logid);?>"><?php echo $log_title; ?></a></h4>
						</div>
						<p class="post-info">
							<span><i class="fa fa-calendar"></i> <?php echo gmdate('m-d', $date); ?></span>
							<span><i class="fa fa-eye"></i> <?php echo $views; ?>人</span>
						</p>
					</div>
					<!-- 小型设备文章显示结束 -->
										
          <article class="zan-single-content">				                 
<?php echo $log_content; ?>
          </article>
	        <!-- 百度分享 -->
	        <div class="zan-share clearfix">
                      <div class="article-tags"><?php blog_tag($logid); ?></div>

            		       <?php doAction('log_related', $logData); ?>
		      </div>
					<!-- 百度分享结束 -->
                        <?php if ($copyright == "yes"): ?>
					<!-- 文章版权信息 -->
					<div class="copyright well">
						<p>
							版权属于:
							<a href="<?php echo BLOG_URL; ?>" title="<?php echo $blogname; ?>"><?php echo $blogname; ?></a>						</p>
						<p>
							原文地址:
							<a href="http://blog.cccyun.cn/?post=<?php echo $logid; ?>">http://blog.cccyun.cn/?post=<?php echo $logid; ?></a>						<p>转载时必须以链接形式注明原始出处及本声明。</p>
					</div>
					<!-- 文章版权信息结束 -->
                    <?php else:?>
     <?php endif; ?>
          <!-- 分页 -->
          <div clas="zan-page">
            <ul class="pager">
              <?php neighbor_log($neighborLog); ?>
            </ul>
          </div>
          <!-- 分页结束 -->
				</article>
				<!-- 广告 -->
                <!-- 广告结束 -->
				<div class="hidden-xs" id="post-related">
        	<div id="related-title"><i class="fa fa-share-alt"></i> 相关推荐</div>
					<ul>
					<?php if ($ganxq == "yes"): ?>
                    <?php related_logs($logData);?> 
                    <?php else: ?>
					<?php $index_hotlognum = Option::get('index_hotlognum');	$Log_Model = new Log_Model();	$randLogs = $Log_Model->getHotLog(8);?> <?php foreach($randLogs as $value): ?><li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li><?php endforeach; ?><?php endif; ?></ul>
				</div>
                
                <div id="comments-template">
  <div class="comments-wrap">
    <div id="comments">
               		<?php blog_comments($comments,$comnum); ?>

</div>
<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark);?>
</div>
</div>
                
							</div>

				<?php
 include View::getView('eside');
 include View::getView('footer');
?>