<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<footer id="zan-footer">
	<section class="footer-space">
    <div class="footer-space-line"></div>
    </section>
	<section class="zan-copyright">
		<div class="container">
			Powered by <a href="http://www.emlog.net" title="采用emlog系统">EMLOG</a> . <?php if ($banquan == "yes"): ?><?php if (blog_tool_ishome()) :?>Theme Modify <a href="http://flyercn.com"  target="_blank">FLYER</a> . <?php else:?>Theme Modify <span id="official">FLYER</span><?php endif; ?><?php else: ?><?php endif; ?> <?php if ($timer == "yes"): ?>  加载耗时 <?php timer_stop(3) ?>s<?php else: ?><?php endif; ?> <?php if(_g('tongji')){?><?php echo _g('tongji'); ?><?php }else{?><?php }?>  <?php echo $footer_info; ?>  <?php doAction('index_footer'); ?>
		</div>
	</section>
</footer>
<div id="zan-gotop">
  <div class="gotop">
    <i class="fa fa-chevron-up"></i>
  </div>
</div>
<script type='text/javascript' src='http://libs.useso.com/js/jquery/2.1.1/jquery.min.js?ver=2.1.1'></script>
<script type='text/javascript' src='http://cdn.bootcss.com/jquery-migrate/1.2.1/jquery-migrate.min.js?ver=1.2.1'></script>
<script type="text/javascript" src="/include/lib/js/common_tpl.js"></script>
<script type='text/javascript' src='http://libs.useso.com/js/bootstrap/3.1.1/js/bootstrap.min.js?ver=3.1.1'></script>
<script type='text/javascript' src='http://libs.useso.com/js/flexslider/2.2.0/jquery.flexslider-min.js?ver=3.0.0'></script>
<script type='text/javascript' src='/content/templates/zanblog3/ui/js/zan.js?ver=3.0.0'></script>
<!--[if lt IE 9]>
  <script src="/content/templates/zanblog3/ui/js/modernizr.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<![endif]-->


<script type='text/javascript'>
  backTop = function ( btnId ) {
    var btn =document.getElementById( btnId );
    var d = document.documentElement;
    var b = document.body;
    window.onscroll = set;
    btn.onclick = function () {
      btn.style.display = "none";
      window.onscroll = null;
      this.timer = setInterval( function() {
        d.scrollTop -= Math.ceil( ( d.scrollTop + b.scrollTop ) * 0.1 );
        b.scrollTop -= Math.ceil( ( d.scrollTop + b.scrollTop ) * 0.1 );
        if( ( d.scrollTop + b.scrollTop ) == 0 ) clearInterval( btn.timer, window.onscroll=set );
      }, 10 );
    };
    function set() { btn.style.display = ( d.scrollTop + b.scrollTop > 100 ) ? 'block' : "none" }
  };
  backTop( 'zan-gotop' );
</script>
<script>prettyPrint();</script>
</body>
</html>