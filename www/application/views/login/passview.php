<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Head BEGIN -->
<head>
	<meta charset="utf-8">
	<title><?=SCHOOLTITLE?></title>

	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta content="Metronic Shop UI description" name="description">
	<meta content="Metronic Shop UI keywords" name="keywords">
	<meta content="keenthemes" name="author">

	<meta property="og:site_name" content="-CUSTOMER VALUE-">
	<meta property="og:title" content="-CUSTOMER VALUE-">
	<meta property="og:description" content="-CUSTOMER VALUE-">
	<meta property="og:type" content="website">
	<meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
	<meta property="og:url" content="-CUSTOMER VALUE-">

	<link rel="shortcut icon" href="<?php echo base_url(FAVICONURL);?>"/>

	<!-- Fonts START -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
	<!-- Fonts END -->

	<!-- Global styles START -->          
	<link href="<?php echo base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
	<!-- Global styles END --> 
	<link href="<?php echo base_url('assets/global/plugins/bootstrap-toastr/toastr.min.css');?>" rel="stylesheet" type="text/css"/>

	<!-- Page level plugin styles END -->
	<!-- Theme styles START -->
	<link href="<?php echo base_url('assets/global/css/components.css');?>" id="style_components" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/frontend/layout/css/style.css')?>" rel="stylesheet">  
	<!-- metronic revo slider styles -->
	<link href="<?php echo base_url('assets/frontend/layout/css/style-responsive.css')?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/frontend/layout/css/themes/blue.css')?>" rel="stylesheet" id="style-color">
	<link href="<?php echo base_url('assets/custom/styles.css')?>" rel="stylesheet">
	<style type="text/css">
		.page-content{
			background: #ebf7f9;
		}
		.pass-alert{
			position: relative;
			width: 360px;
			margin: 86px auto;
			padding: 0;
			border: 1px solid #3b7dd8;
			border-radius: 5px !important;
		}
		.pass-alert h1{
			width: fit-content;
		    position: relative;
		    margin: 0 auto;
		}
		.pass-alert h3{
			font-weight: 600 !important;
    		margin-bottom: 0 !important;
    		color: #136ec2 !important;
		}
		.pass-success{color:#3b7dd8;}
		.pass-danger{color:red;}
		.forget-form p {
			margin-top: 5px;
    		margin-left: 10px;
    		color: #136ec2 !important;
		}
		.forget-form{
			height: 220px;
		}
		.forget-form input,
		.forget-form button{border-radius: 5px !important;}
		.forget-form button{margin-right: 10px; width: 94%;}
	</style>
</head>
<!-- Head END -->
<!-- Body BEGIN -->
<body class="ecommerce"><!-- add class page-header-fixed, if you want to fix header -->
	<!-- #be6e6e -->
	<!-- #be6e6e --><!-- BEGIN HEADER -->
<div class="header">
	<div class="container">
		<a class="site-logo" href="<?=site_url('')?>"><img src="<?php echo base_url(FRONTENDLOGOIMGURL)?>" alt="Metronic FrontEnd" height="45" ></a>

		<!-- BEGIN NAVIGATION -->
		<div class="header-navigation pull-right font-transform-inherit">
			
		</div>
		<!-- END NAVIGATION -->
	</div>
</div>
<!-- Header END -->
<div class="page-content" style="min-height: 913px;">
	<div class="main">
		<div class="container">
			<?php
			if (isset($color)) {
			?>
			<style type="text/css">
				.pass-alert h1{font-size: 20px;padding: 5px;}
			</style>
			<div class="pass-alert">
				<h1 class="<?=$color?>"><?=$string?></h1>
			</div>
			<?php
			}else{
			?>
			<div class="pass-alert">
				<form class="forget-form" action="<?=site_url('login/update_password')?>" method="post">
				<div class="form-header">
					<h3 class="form-title">重置密码</h3>
				</div>
				<p>
				<?php
					if (isset($nomatch)) {
						echo $nomatch;
					}
				?>
				</p>
				<div class="form-group">
					<div class="input-icon">
						<i class="fa fa-lock"></i>
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="新密码" name="password"/>
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon">
						<i class="fa fa-lock"></i>
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="重复输入密码" name="cpassword"/>
					</div>
				</div>
				<input type="hidden" name="reset_pass" value="<?=$temp_pass?>" />
				<div class="form-actions">
					<button type="submit" class="btn cosmetic-btn pull-right">
					提交 <i class="fa fa-arrow-circle-o-right"></i>
					</button>
				</div>
			</form>
			</div>
			<?php
			}
			?>
		</div>
	</div>
</div>


<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="http://localhost/Cosmetics/assets/global/plugins/respond.min.js"></script>
<![endif]--> 
<script src="<?php echo base_url('assets/global/plugins/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/jquery-migrate.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/global/plugins/bootstrap-toastr/toastr.min.js');?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url('assets/frontend/layout/scripts/layout.js')?>" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();    
    });
    var fixPageContentHeight = function(){
        var windowHeight = $(window).height();
        var headerHeight = $('body .header').outerHeight();
        var footerHeight = $('body .footer').outerHeight();
        var pagecontentHeight = windowHeight - headerHeight - footerHeight;
        $('body .page-content').css('min-height' , pagecontentHeight);
    }

    fixPageContentHeight();

</script>

</body>
<!-- END BODY -->
</html>