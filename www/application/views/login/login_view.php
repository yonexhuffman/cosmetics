<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url('assets/admin/pages/css/login-soft.css');?>" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->

<style type="text/css">
.page-content{background-color:#ebf7f9 !important;}
.login{background-color:#ebf7f9 !important;}
.login .content h3{
	font-weight:600 !important;
	margin-bottom:0 !important;
	color: #136ec2 !important;
}
.login .content{
	background: #ebf7f9;
	margin: 86px auto;
	border: 1px solid #3b7dd8;
	border-radius: 5px !important;
	padding: 0;
}
.login .content .form-actions{
	height: fit-content;
	margin: -5px 0 13px 5px;
	padding: 0px 10px 10px 5px;
}
.login .content .register-form .form-actions{
	margin-bottom: 5px;
	padding-left: 5px;
}
.form-actions .donglu{width: 100%;margin-bottom: 40px;}
.form-actions .dotted{color: #3b7dd8;margin: 0 5px;}
.register-form p,
.login .content h4,
.login .content p, 
.login .content label,
.forget a{color: #3b7dd8 !important}
.login .content .form-control,
.form-actions .donglu{border-radius: 3px !important;}
.form-actions a:hover{text-decoration: underline;}
.login form p{margin-top: 5px;margin-left: 10px;}

</style>
<div class="main login">
	<div class="container">
		<div class="content">
			<!-- BEGIN LOGIN FORM -->
			<form class="login-form" action="<?=site_url('login/signin')?>" method="post">
				<div class="form-header">
					<h3 class="form-title">用户登陆</h3>
				</div>
				<div class="alert alert-danger <?php if(isset($error) && $error == "") echo "display-hide";?>">
					<button class="close cosmetic-btn" data-close="alert"></button>
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
					<button type="submit" class="btn cosmetic-btn pull-right donglu">
					登录 <i class="fa fa-arrow-circle-o-right"></i>
					</button>
				</div>	
				<div class="form-actions forget">
					<a href="javascript:;" id="register-btn" class="pull-right">注册帐号</a>
					<span class="dotted pull-right">|</span>
					<a href="javascript:;" id="forget-password" class="pull-right">忘了密码？</a>
				</div>
			</form>
			<!-- END LOGIN FORM -->
			<!-- BEGIN FORGOT PASSWORD FORM -->
			<form class="forget-form" action="<?=site_url('login/recover_password')?>" method="post">
				<div class="form-header">
					<h3 class="form-title">重置密码</h3>
				</div>
				<p>
					 电子邮件：
				</p>
				<div class="form-group">
					<div class="input-icon">
						<i class="fa fa-envelope"></i>
						<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="电子邮件" name="email"/>
					</div>
				</div>
				<div class="form-actions">
					<button type="button" id="back-btn" class="btn cosmetic-btn">
					<i class="fa fa-arrow-circle-o-left"></i> 返回 </button>
					<button type="submit" class="btn cosmetic-btn pull-right">
					提交 <i class="fa fa-arrow-circle-o-right"></i>
					</button>
				</div>
			</form>
			<!-- END FORGOT PASSWORD FORM -->
			<!-- BEGIN REGISTRATION FORM -->
			<form class="register-form" action="<?=site_url('login/createaccount')?>" method="post">
				<div class="form-header">
					<h3 class="form-title">创建帐号</h3>
				</div>
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
					<button id="register-back-btn" type="button" class="btn cosmetic-btn">
					<i class="fa fa-arrow-circle-o-left"></i> 返回 </button>
					<button type="submit" id="register-submit-btn" class="btn cosmetic-btn pull-right">
					创建帐号 <i class="fa fa-arrow-circle-o-right"></i>
					</button>
				</div>
			</form>
			<!-- END REGISTRATION FORM -->
		</div>
	</div>
</div>