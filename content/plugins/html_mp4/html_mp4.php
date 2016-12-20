<?php
/*
Plugin Name: HTML网页手机播放器
Version: 1.0
Plugin URL: http://www.emlog.info
Description: 一次插入永久使用，还不赶快去发个视频看看？点击作者网站吧你的网站让更多小伙伴看到吧！
Author: .com
Author Email: a77q77@163.com
Author URL: http://www.emlog.info
*/
!defined('EMLOG_ROOT') && exit('access deined!');
function mp4_js() {
	echo '<script type="text/javascript" src="'.BLOG_URL.'content/plugins/html_mp4/solu.js"></script>'."\r\n";
	}
function mp4_tool(){?>
<script>
$(document).ready(function(){
$(".mp4_charu").click(function(){
$($(".ke-edit-iframe:first").contents().find(".ke-content")).append("<p><video src="+($('#mediaurl').val())+"  width='"+($('#mediawidth').val())+"' height='"+($('#mediaheight').val())+"' controls='controls' autoplay='' /></p>");
});
//关闭按钮
$(".gb_niu").click(function(){
$("#mp4_ban").css("display","none");}); 
$("#mp4_mp4").click(function(){
$("#mp4_ban").css("display","block");}); 
});
</script>
<style>
#mp4_box{font-weight:bold;font-size:12px;margin:5px 0; cursor:pointer;}
#mp4_box #mp4_mp4{width:50px;height:auto;border: 0;padding: 3px 3px;font-size: 12px;margin: 3px 3px 3px 0;color: #fff;background-color: #20A2DE;cursor:pointer;text-align:center;}
#mp4_box #mp4_mp4:hover{background-color:#ff9000;}
#mp4_ban{font-weight:normal;margin:5px 0 10px 0;display:none;border: 1px solid #ccc;padding: 10px;width:500px;float:left}
#mp4_ban p{margin:0 0 10px 0;font-size:14px;}
#mp4_ban input[type="text"]{width:400px;font-size:12px; outline:none}
#mp4_ban span{cursor:pointer;padding:3px 3px;float:left;font-size: 14px;margin: 0 10px 0 0;background: #5cb85c;color:#fff;font-weight:bold;}
#mp4_ban span:hover{background:#00aff0 !important;color:#fff !important;}
#mediawidth,#mediaheight{width:55px !important;}
</style>
<div id="mp4_box">
<div id="mp4_mp4">MP4</div> 
<div id="mp4_ban">
<p>视频地址：<input type="text" name="mediaurl" id="mediaurl" placeholder="视频地址必须.MP4结尾，否则不能播放" /></p>
<p>设置宽度：<input type="text" name="mediawidth" id="mediawidth" value="100%" /></p>
<p>设置高度：<input type="text" name="mediaheight" id="mediaheight" value="100%" /></p>
<p style="margin:10px 0 10px 0px;"><span class="mp4_charu">插入代码</span> <span class="gb_niu">关闭工具</span></p></div>
</div><div style="clear:both"></div>
<?php
 }
addAction('index_head', 'mp4_js');
addAction('adm_writelog_head', 'mp4_tool');
