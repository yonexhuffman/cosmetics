<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['menu'] = array(
	'1' => array(
			'title'	=> '首页' , 
			'url'	=> '/search' , 
		) , 
	'2' => array(
			'title'	=> '排名榜' , 
			'url'	=> '/rating' , 
		) , 
	'3' => array(
			'title'	=> '化妆品列表' , 
			'url'	=> '/product' , 
		) , 
	'4' => array(
			'title'	=> '成分查询' , 
			'url'	=> '/ingredient' , 
		) , 
	// '5' => array(
	// 		'title'	=> '我的' , 
	// 		'url'	=> '/dashboard' , 
	// 	) , 
	// '6' => array(
	// 		'title'	=> '登录' , 
	// 		'url'	=> '/login' , 
	// 	) , 
);

$config['ratingmenu'] = array(
	'1' => array('title' => '人气排名榜') , 
	'2' => array('title' => '品牌排名榜') , 
	'3' => array('title' => '新品排名榜') , 
);

$config['favkey'] = array(
	'1' => '保湿', 
	'2' => '理肤泉', 
	'3' => '资生堂',
	'4' => '面膜',
	'5' => '雪花秀',
	'6' => '雅漾',
	'7' => '雅诗兰黛',
	'8' => '芙丽芳丝',
	'9' => '美白',
	'10' => '悦诗风吟',
	'11' => '祛痘',
);