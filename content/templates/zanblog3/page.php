<?php 
/**
 * 自建页面模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php if($log_title =="读者排行" || $log_title =="读者墙"):?>
<style>
.container{max-width:1200px;margin:0 auto;text-align:left;position:relative;*zoom:1}.container{max-width:1200px;margin:0 auto;text-align:left;position:relative;*zoom:1}.container:before,.container:after{display:table;content:"";line-height:0}.container:after{clear:both}section.container{background-color:#fff;border-radius:5px;box-shadow:0 2px 0 0 rgba(0,0,0,0.04)}.no-sidebar{margin-right:0}.article-header{padding:0 0 12px;border-bottom:1px solid #f2f2f2;margin-bottom:20px;text-align:center}.article-header .text-muted{font-size:12px;margin-bottom:0}.article-title{font-size:26px;margin-top:5px;line-height:1.2}.article-title a{color:#444}.article-title a:hover{color:#ff5e52;text-decoration:underline}.content-wrap{width:100%;float:left}.content{margin-right:370px;margin-left:0;min-height:500px;padding:15px 20px}.readers{overflow:hidden}.readers a{width:72px;margin:0 5px 25px 5px;float:left;text-align:center;color:#999;font-size:12px;height:65px;overflow:hidden;text-decoration:none}.readers a:hover{color:#ff5e52}.readers .avatar{border-radius:5px;margin:0 auto;display:block;margin-bottom:5px}.readers a.item-top{width:31.222222%;margin:0 1% 30px;text-align:left;height:100px;color:#bbb;background-color:#f6f6f6;border-radius:5px;padding:10px}.readers a.item-top .avatar{float:left;margin-left:10px;margin-right:10px}.readers a.item-top h4{color:#ff5e52;font-size:16px}.readers a.item-top strong{display:block;color:#666}.readers a.item-top:hover{background-color:#f1f1f1}.readers a.item-2 h4{color:#7ccd38}.readers a.item-3 h4{color:#52baf5}.affix{position:fixed}
</style>
<div id="zan-bodyer">
	<div class="container">
		<section class="row">
        <div class="col-md-8">
<?php
global $CACHE;$user_cache = $CACHE->readCache('user');$name = $user_cache[1]['name'];
$DB = MySql :: getInstance();
$sql = "SELECT count(*) AS comment_nums,poster,mail,url FROM ".DB_PREFIX."comment where date >0 and poster !='". $name ."' and  poster !='匿名' and hide ='n' group by poster order by comment_nums DESC limit 0,280";
$result = $DB -> query( $sql );
$x=1; 
while( $row = $DB -> fetch_array( $result ) )
if ($x<=1) {
{
$img = "<a class=\"item-top item-".$x."\" target=\"_blank\" href=". $row[ 'url' ] ."><h4>【金牌读者】<small>评论：". $row[ 'comment_nums' ] ."</small></h4><img alt='' data-src=".getGravatar( $row[ 'mail' ]) ." class=\"avatar avatar-36 photo\" height=\"36\" width=\"36\" /><strong>". $row[ 'poster' ] ."</strong>". $row[ 'url' ] ."</a>";
 if( $row[ 'url' ] )
{$tmp = "<a class=\"item-top item-".$x."\" target=\"_blank\" href=". $row[ 'url' ] ."><h4>【金牌读者】<small>评论：". $row[ 'comment_nums' ] ."</small></h4><img alt='' src=".getGravatar( $row[ 'mail' ]) ." class=\"avatar avatar-36 photo\" height=\"36\" width=\"36\" /><strong>". $row[ 'poster' ] ."</strong>". $row[ 'url' ] ."</a>";
}
else
{$tmp = $img;}
$output .= $tmp;
$x++;
}
}elseif($x<=2){
$img = "<a class=\"item-top item-2\" target=\"_blank\" href=". $row[ 'url' ] ."><h4>【银牌读者】<small>评论：". $row[ 'comment_nums' ] ."</small></h4><img alt='' src=".getGravatar( $row[ 'mail' ]) ." class=\"avatar avatar-36 photo\" height=\"36\" width=\"36\" /><strong>". $row[ 'poster' ] ."</strong>". $row[ 'url' ] ."</a>";
 if( $row[ 'url' ] )
{$tmp = "<a class=\"item-top item-2\" target=\"_blank\" href=". $row[ 'url' ] ."><h4>【银牌读者】<small>评论：". $row[ 'comment_nums' ] ."</small></h4><img alt='' src=".getGravatar( $row[ 'mail' ]) ." class=\"avatar avatar-36 photo\" height=\"36\" width=\"36\" /><strong>". $row[ 'poster' ] ."</strong>". $row[ 'url' ] ."</a>";
}
else
{$tmp = $img;}
$output .= $tmp;
$x++;
}elseif($x<=3){
$img = "<a class=\"item-top item-3\" target=\"_blank\" href=". $row[ 'url' ] ."><h4>【铜牌读者】<small>评论：". $row[ 'comment_nums' ] ."</small></h4><img alt='' src=".getGravatar( $row[ 'mail' ]) ." class=\"avatar avatar-36 photo\" height=\"36\" width=\"36\" /><strong>". $row[ 'poster' ] ."</strong>". $row[ 'url' ] ."</a>";
 if( $row[ 'url' ] )
{$tmp = "<a class=\"item-top item-3\" target=\"_blank\" href=". $row[ 'url' ] ."><h4>【铜牌读者】<small>评论：". $row[ 'comment_nums' ] ."</small></h4><img alt='' src=".getGravatar( $row[ 'mail' ]) ." class=\"avatar avatar-36 photo\" height=\"36\" width=\"36\" /><strong>". $row[ 'poster' ] ."</strong>". $row[ 'url' ] ."</a>";
}
else
{$tmp = $img;}
$output .= $tmp;
$x++;
}elseif($x>=4){
$img = "";
 if( $row[ 'url' ] )
{$tmp = "<a target=\"_blank\" href=\"". $row[ 'url' ] ."\" title=\"【第".$x."名】 评论：". $row[ 'comment_nums' ] ."\"><img alt='' src=".getGravatar( $row[ 'mail' ]) ." class=\"avatar avatar-36 photo\" height=\"36\" width=\"36\" />". $row[ 'poster' ] ."</a>";
}
else
{$tmp = $img;}
$output .= $tmp;
$x++;
}
$output = '<section class="container"><div class="content no-sidebar">
		<header class="article-header">
			<h1 class="article-title">读者排行</h1>
		</header><div class="readers">'. $output .'</div></section>';
echo $output ;
 ?>
</div>
</section>
</div>
</div>
 <?php include View::getView('footer');
?>
<?php else:?>
<div id="zan-bodyer">
	<div class="container">
		<section class="row">
			<div class="col-md-8">
				<article class="zan-article">
					<!-- 面包屑 -->
					<div class="breadcrumb">
					    <i class="fa fa-map-marker"></i>
<a title="Go to index." href="<?php echo BLOG_URL; ?>" class="home">首页</a> / <?php echo $log_title; ?>	</div>
	 <article class="zan-single-content">				                 
      <?php echo $log_content; ?>
      </article>
</article>
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
<?php endif; ?>