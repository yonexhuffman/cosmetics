<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['menu'] = array(
	'11' => array(
			'icon'	=> 'icon-user' , 
			'title'	=> '用户管理' , 
			'url'	=> '/admin/account' , 
			'fa_icon'	=> 'fa-user' , 
		) , 
	// '1' => array(
	// 		'icon'	=> 'icon-hourglass' , 
	// 		'title'	=> '数据抓取-1' , 
	// 		'url'	=> '/admin/datascrapping' , 
	// 		'fa_icon'	=> 'fa-home' , 
	// 	) , 
	// '12' => array(
	// 		'icon'	=> 'icon-wallet' , 
	// 		'title'	=> '数据抓取-bevol' , 
	// 		'url'	=> '/admin/datascrapping/newcategory' , 
	// 		'fa_icon'	=> 'fa-home' , 
	// 	) , 
	// '13' => array(
	// 		'icon'	=> 'icon-screen-desktop' , 
	// 		'title'	=> '数据抓取' , 
	// 		'url'	=> '/admin/datascrapping/statesite' , 
	// 		'fa_icon'	=> 'fa-database' , 
	// 	) , 
	'15' => array(
			'icon'	=> 'icon-screen-desktop' , 
			'title'	=> '数据抓取' , 
			'url'	=> '/admin/datascrapping/ultimate' , 
			'fa_icon'	=> 'fa-database' , 
		) , 
	'2' => array(
			'icon'	=> 'icon-notebook' , 
			'title'	=> '电商目录' , 
			'url'	=> '/admin/shoppingcategory' , 
			'fa_icon'	=> 'fa-book' , 
		) , 
	'14' => array(
			'icon'	=> 'icon-book-open' , 
			'title'	=> '购买次数' , 
			'url'	=> '/admin/visitcount' , 
			'fa_icon'	=> 'fa-database' , 
		) , 
	'3' => array(
			'icon'	=> 'icon-layers' , 
			'title'	=> '化妆品管理' , 
			'url'	=> '/admin/product' , 
			'fa_icon'	=> 'fa-database' , 
		) , 
	'4' => array(
			'icon'	=> 'icon-puzzle' , 
			'title'	=> '成分管理' , 
			'url'	=> '/admin/ingredient' , 
			'fa_icon'	=> 'fa-database' , 
		) , 
	// '7' => array(
	// 		'icon'	=> 'icon-equalizer' , 
	// 		'title'	=> '评论标签' , 
	// 		'url'	=> '/admin/blogtags' , 
	// 		'fa_icon'	=> 'fa-fax' , 
	// 	) , 
	'5' => array(
			'icon'	=> 'icon-book-open' , 
			'title'	=> '化妆品评价管理' , 
			'url'	=> '/admin/blog' , 
			'fa_icon'	=> 'fa-database' , 
		) , 
	'16' => array(
			'icon'	=> 'icon-book-open' , 
			'title'	=> '成分评价管理' , 
			'url'	=> '/admin/blogingredient' , 
			'fa_icon'	=> 'fa-database' , 
		) , 
	'8' => array(
			'icon'	=> 'icon-screen-desktop' , 
			'title'	=> '商标管理' , 
			'url'	=> '/admin/company' , 
			'fa_icon'	=> 'fa-fax' , 
		) , 
	'9' => array(
			'icon'	=> 'icon-layers' , 
			'title'	=> '用户意见反馈' , 
			'url'	=> '/admin/opinions' , 
			'fa_icon'	=> 'fa-fax' , 
		) , 
	'6' => array(
			'icon'	=> 'icon-bubbles' , 
			'title'	=> '管理者信息' , 
			'url'	=> '/admin/admininfo' , 
			'fa_icon'	=> 'fa-fax' , 
		) , 
	'10' => array(
			'icon'	=> 'icon-logout' , 
			'title'	=> '退出' , 
			'url'	=> '/admin/login/signup' , 
			'fa_icon'	=> 'fa-user' , 
		) , 
);

$config['is_active'] = array(
	'0' => '没有',
	'1' => '有'
);

$config['user_role'] = array(
	'ADMIN'	=> '管理员' , 
	'USER'	=> '用户'
);
