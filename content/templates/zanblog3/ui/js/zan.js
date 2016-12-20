/**
 * ZanBlog JavaScript File
 *
 * 为了提高用户使用ZanBlog时的用户体验。
 *
 * Author: 佚站互联（YEAHZAN）
 *
 * Site: http://www.yeahzan.com/
 */

jQuery(window).load(function() {
  zan.flexslider();
});


jQuery(function($) {
	zan.init();
});

audiojs.events.ready(function() {
    var as = audiojs.createAll();
});

var zan = {

	//初始化函数
	init: function() {
		this.dropDown();
		this.setImgHeight();
    this.addAnimation();
    this.archivesNum();
    this.scrollTop();
    this.ajaxCommentsPage();
	},

	// 设置导航栏子菜单下拉交互
	dropDown: function() {
		var dropDownLi = jQuery('.nav.navbar-nav li');

		dropDownLi.mouseover(function() {
			jQuery(this).addClass('open');
		}).mouseout(function() {
			jQuery(this).removeClass('open');
		});
	},

	// 设置文章图片高度
	setImgHeight: function() {
		var img = jQuery(".zan-single-content").find("img");

		img.each(function() {
			var $this 		 = jQuery(this),
					attrWidth  = $this.attr('width'),
					attrHeight = $this.attr('height'),
					width 		 = $this.width(),
					scale      = width / attrWidth,
					height     = scale * attrHeight;

			$this.css('height', height);

		});
	},

  // 为指定元素添加动态样式
  addAnimation: function() {
    var animations = jQuery("[data-toggle='animation']");

    animations.each(function() {
      jQuery(this).addClass("animation", 2000);
    });
  },

	// 设置首页幻灯片
	flexslider: function() {
		jQuery('.flexslider').flexslider({
	    animation: "slide"
	  });
	},

	// 设置每月文章数量
	 archivesNum: function() {
		jQuery('#archives .panel-body').each(function() {
			var num = jQuery(this).find('p').size();
			var archiveA = jQuery(this).parent().siblings().find("a");
			var text = archiveA.text();

			archiveA.html(text + ' <small>(' + num + '篇文章)</small>');
		});
 	},

 	//头部固定
 	scrollTop: function() {
		//获取要定位元素距离浏览器顶部的距离 
		var navH = jQuery("#zan-nav").offset().top; 

		//滚动条事件 
		jQuery(window).scroll(function(){ 
			//获取滚动条的滑动距离 
			var scroH = jQuery(this).scrollTop(); 

			//滚动条的滑动距离大于等于定位元素距离浏览器顶部的距离，就固定，反之就不固定 
			if(scroH>=navH){ 
				//jQuery("#zan-nav").addClass("navbar-fixed-top"); 

			}else if(scroH<navH){ 
				jQuery("#zan-nav").removeClass("navbar-fixed-top"); 
			} 

		}); 
	},

	// ajax评论分页
	ajaxCommentsPage: function() {
		var $ = jQuery.noConflict();

		$body=(window.opera)?(document.compatMode=="CSS1Compat"?$('html'):$('body')):$('html,body');
		// 点击分页导航链接时触发分页
		$('#comment-nav a').live('click', function(e) {
		    e.preventDefault();
		    $.ajax({
		        type: "GET",
		        url: $(this).attr('href'),
		        beforeSend: function(){
		            $('#comment-nav').remove();
		            $('.comment-list').remove();
		            $('#loading-comments').slideDown();
		            $body.animate({scrollTop: $('#comments-number').offset().top - 65}, 800 );
		        },
		        dataType: "html",
		        success: function(out){
		            result = $(out).find('.comment-list');
		            nextlink = $(out).find('#comment-nav');

		            $('#loading-comments').slideUp('fast');
		            $('#loading-comments').after(result.fadeIn(500));
		            $('.comment-list').after(nextlink);
		        }
		    });
		});
	}
}