<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.7.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?=SCHOOLTITLE?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css"/><!-- aa -->
<link href="<?php echo base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/global/plugins/uniform/css/uniform.default.css');?>" rel="stylesheet" type="text/css"/><!-- aa -->
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url('assets/admin/pages/css/login-soft.css');?>" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url('assets/global/css/components.css');?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/global/css/plugins.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/admin/layout/css/layout.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('assets/admin/layout/css/themes/default.css');?>" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url('assets/admin/layout/css/custom.css');?>" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo base_url(FAVICONURL);?>"/>
</head>
<style type="text/css">
	@media (max-width: 1024px){
		.login .content{
			margin-top: 25%;
		}		
	}
	@media (min-width: 1025px){
		.login .content{
			margin-top: 5%;
		}		
	}
</style>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<!-- <div class="logo">
	<a href="<?=site_url('')?>">
	<img src="<?php echo base_url(FRONTENDLOGOIMGURL);?>" alt=""/>
	</a>
</div> -->
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="<?=site_url('login/signin')?>" method="post">
		<h3 class="form-title">用户登陆</h3>
		<div class="alert alert-danger <?php if(isset($error) && $error == "") echo "display-hide";?>">
			<button class="close" data-close="alert"></button>
			<span>
			<?php
				if (isset($error) && $error != "") {
					echo $error;
				}
				else {
					echo "请输入正确的用户名或密码.";
				}
			?> 
			</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">账号</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="账号" name="user_id"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">密码</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="密码" name="user_password"/>
			</div>
		</div>
		<div class="form-actions">
			<button id="register-btn" type="button" class="btn">
			<i class="fa fa-user"></i> Create Account </button>
			<button type="submit" class="btn blue pull-right">
			登录 <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>	
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN REGISTRATION FORM -->
	<form class="register-form" action="<?=site_url('login/createaccount')?>" method="post">
		<h3>创建帐号</h3>
		<p>
			 在下面输入您的个人信息：
		</p>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">用户名</label>
			<div class="input-icon">
				<i class="fa fa-font"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="用户名" name="user_nickname"/>
			</div>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">电子邮件</label>
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="电子邮件" name="user_email"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">电话号码</label>
			<div class="input-icon">
				<i class="fa fa-phone"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="电话号码" name="user_phonenumber"/>
			</div>
		</div>
		<p>
			 在下面输入您的帐户详情：
		</p>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">账号</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="账号" name="user_id"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">密码</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="密码" name="user_password"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">确认密码</label>
			<div class="controls">
				<div class="input-icon">
					<i class="fa fa-check"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="确认密码" name="rpassword"/>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<button id="register-back-btn" type="button" class="btn">
			<i class="m-icon-swapleft"></i> 返回 </button>
			<button type="submit" id="register-submit-btn" class="btn blue pull-right">
			创建帐号 <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	<!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	2018 &copy; <?=SCHOOLTITLE?>.
</div>
<!-- END COPYRIGHT -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url('assets/global/plugins/respond.min.js');?>"></script>
<script src="<?php echo base_url('assets/global/plugins/excanvas.min.js');?>"></script>
<![endif]-->
<script src="<?php echo base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/jquery-migrate.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/uniform/jquery.uniform.min.js');?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/backstretch/jquery.backstretch.min.js');?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url('assets/global/scripts/metronic.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/layout/scripts/layout.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/layout/scripts/demo.js');?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init();
	// init background slide images
	$.backstretch([
		    "<?php echo base_url('uploads/bg/1.jpg');?>",
		    "<?php echo base_url('uploads/bg/2.jpg');?>",
		    "<?php echo base_url('uploads/bg/3.jpg');?>",
		    "<?php echo base_url('uploads/bg/4.jpg');?>"
		    ], {
		      fade: 1000,
		      duration: 8000
		}
	);

	var handleLogin = function() {
		$('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                user_id: {
                    required: true
                },
                user_password: {
                    required: true
                }
            },

            messages: {
                user_id: {
                    required: "请输入用户名."
                },
                user_password: {
                    required: "请输入密码."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit();
                }
                return false;
            }
        });
	}

    handleLogin();
	
	var handleRegister = function () {

         $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {	                
	                user_nickname: {
	                    required: true
	                },
	                user_email: {
	                    required: true,
	                    email: true
	                },
	                user_phonenumber: {
	                    required: true
	                },
	                user_id: {
	                    required: true
	                },
	                user_password: {
	                    required: true
	                },
	                rpassword: {
	                    equalTo: "#register_password"
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes              
	                user_nickname: {
	                    required: "这是必填栏。"
	                },
	                user_email: {
	                    required: "这是必填栏。",
	                    email: "电子邮件格式错误。"
	                },
	                user_phonenumber: {
	                    required: "这是必填栏。"
	                },
	                user_id: {
	                    required: "这是必填栏。"
	                },
	                user_password: {
	                    required: "这是必填栏。"
	                },
	                rpassword: {
	                    equalTo: "验证密码不正确。"
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	            	if (!ischeckuserid) {
	                	form.submit();
	            	}
	            	else {
	            		$('.register-form input[name=user_id]').parents('.form-group').addClass('has-error').find('.help-block').html('This userid already exists !').show();
	            	}
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}

	handleRegister();

	var ischeckuserid = false;
	$(document).on('keyup' , '.register-form input[name=user_id]' , function(){
		var user_id = $(this).val();
		var formgroup_element = $(this).parents('.form-group');
		if (user_id != '') {
			$.ajax({
				url : '<?=site_url('login/checkuserid')?>' , 
				type: 'POST' , 
				dataType: 'JSON' , 
				data: {
					user_id : user_id
				} , 
				success: function(response) {
					if (response.success) {
						ischeckuserid = true;
						formgroup_element.addClass('has-error');
						if (formgroup_element.find('.help-block').length == 0) {
							formgroup_element.append('<span class="help-block">This userid already exists !</span>');
						}
						else {
							formgroup_element.find('.help-block').show();
							formgroup_element.find('.help-block').html('This userid already exists !');
						}
					}
					else {
						ischeckuserid = false;
						formgroup_element.removeClass('has-error');
						formgroup_element.find('.help-block').hide();
					}
				}
			})
		}
	})
    	
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>