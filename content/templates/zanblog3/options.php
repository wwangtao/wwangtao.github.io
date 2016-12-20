<?php

/*@support tpl_options*/
!defined('EMLOG_ROOT') && exit('access deined!');
$options = array(
	    'opentime' => array(
		'type' => 'text',
		'name' => '博客开始建站时间',
		'default' => '2014-10-17',
	),
	    'color' => array(
	    'type' => 'text',
		'name' => '模版主颜色,例如：#428BCA',
		'description' => '为空默认',
		'default' => '',
	),
		'colors' => array(
	    'type' => 'text',
		'name' => '模版副颜色,例如：#3F4452',
		'description' => '为空默认',
		'default' => '',
	),
		'logo' => array(
	    'type' => 'radio',
		'name' => '顶部设置',
	    'description' => '不喜欢该图片请到目录images自己替换',
		'values' => array(
			'yes' => '默认',
			'no' => '使用Banner图片',
		),
		'default' => 'no',
	),
	    'imgcache' => array(
	    'type' => 'radio',
		'name' => 'TimThumb缩略图',
	    'description' => '如果使用，到模版目录中cache权限设置777',
		'values' => array(
			'yes' => '使用',
			'no' => '禁用',
		),
		'default' => 'no',
	),
	    'note' => array(
	    'type' => 'radio',
		'name' => '公告',
		'values' => array(
			'yes' => '显示',
			'no' => '隐藏',
		),
		'default' => 'yes',
	),	
	    'homeside' => array(
	    'type' => 'radio',
		'name' => '首页幻灯片',
		'values' => array(
			'yes' => '显示',
			'no' => '隐藏',
		),
		'default' => 'no',
	),
		'news_img' => array(
	    'type' => 'radio',
		'name' => '幻灯片类型',
		'values' => array(
			'yes' => '最新日记',
			'no' => '指定日记',
		),
		'default' => 'yes',
	),

		'imgaddress' => array(
		'type' => 'text',
		'name' => '日记地址1',
		'description' => '你指定的日记地址',
		'default' => '',
	),
		'focusimg' => array(
		'type' => 'text',
		'name' => '图片地址1',
		'description' => '你指定的图片地址',
		'default' => '',
	),
	    'imgname' => array(
		'type' => 'text',
		'name' => '图片地址名称1',
		'description' => '你指定的名称',
		'default' => '',
	),
		'imgaddress2' => array(
		'type' => 'text',
		'name' => '日记地址2',
		'description' => '你指定的日记地址',
		'default' => '',
	),
		'focusimg2' => array(
		'type' => 'text',
		'name' => '图片地址2',
		'description' => '你指定的图片地址',
		'default' => '',
	),
	    'imgname2' => array(
		'type' => 'text',
		'name' => '图片地址名称2',
		'description' => '你指定的名称',
		'default' => '',
	),
		'imgaddress3' => array(
		'type' => 'text',
		'name' => '日记地址3',
		'description' => '你指定的日记地址',
		'default' => '',
	),
		'focusimg3' => array(
		'type' => 'text',
		'name' => '图片地址3',
		'description' => '你指定的图片地址',
		'default' => '',
	),
	    'imgname3' => array(
		'type' => 'text',
		'name' => '图片地址名称3',
		'description' => '你指定的名称',
		'default' => '',
	),
	 'sortKeywords' => array(
		'type' => 'text',
		'name' => '分类关键词设置',
		'description' => '多个关键词之间用半角逗号隔开',
		'depend' => 'sort',
		'default' => '设置关键词，请不要留空',
	),
     'dengru' => array(
		'type' => 'radio',
		'name' => '是否显示登录',
		'values' => array(
			'yes' => '显示',
			'no' => '隐藏',
		),
		'default' => 'no',
	),
	'sina' => array(
		'type' => 'text',
		'name' => '新浪微博',
		'description' => '你的新浪微博地址',
		'default' => 'http://weibo.com/mopo6688',
	),
		'tengxun' => array(
		'type' => 'text',
		'name' => '腾讯微博',
		'description' => '你的腾讯微博地址',
		'default' => 'http://t.qq.com/net6000',
	),
	 'bofa' => array(
	    'type' => 'radio',
		'name' => '侧栏播放器',
		'values' => array(
			'yes' => '显示',
			'no' => '隐藏',
		),
		'default' => 'no',
	),
	'mp3' => array(
		'type' => 'text',
		'name' => '侧栏音乐',
		'description' => '你的音乐地址',
		'default' => 'http://flyer.pytalhost.com/We-Are-One.mp3',
	),
	    'copyright' => array(
	    'type' => 'radio',
		'name' => '内页版权',
		'values' => array(
			'yes' => '显示',
			'no' => '隐藏',
		),
		'default' => 'yes',
	),
		'ganxq' => array(
	    'type' => 'radio',
		'name' => '相关推荐',
		'values' => array(
			'yes' => '相关日记',
			'no' => '随机热门日记',
		),
		'default' => 'no',
	),
		'smile' => array(
	    'type' => 'radio',
		'name' => '评论表情',
		'values' => array(
			'yes' => '使用',
			'no' => '禁用',
		),
		'default' => 'no',
	),
		'timer' => array(
	    'type' => 'radio',
		'name' => '页面加载耗时',
		'values' => array(
			'yes' => '显示',
			'no' => '隐藏',
		),
		'default' => 'no',
	),
		'banquan' => array(
	    'type' => 'radio',
		'name' => '主题版权信息链接开关',
		'description' => '如果您确实出于SEO需要，减少权重流失。可以点此关掉主题右下角版权信息的超链接，只显示版权文字信息。(此超链接只会在首页显示，内页只显示版权文字)',
		'values' => array(
			'yes' => '启用',
			'no' => '禁用',
		),
		'default' => 'no',
	),
	    'tongji' => array(
		'type' => 'text',
		'name' => '第三方统计代码',
		'description' => '百度统计等等',
		'multi' => true,
		'default' => '',
	),
);