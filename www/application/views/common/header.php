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

	<meta content="瓦呐尔网为您提供91万种以上护肤品、化妆品成分数据查询和包括面部保养、眼唇护理 、唇妆 、眼眉妆 、脸部护理 、手部美甲 、香水等分类的护肤品或化妆品的热门排行榜" name="description">
	<meta content="Metronic Shop UI keywords" name="keywords">
	<meta content="keenthemes" name="author">

	<meta property="og:site_name" content="瓦呐尔">
	<meta property="og:title" content="瓦呐尔网-为用户提供护肤品、化妆品成分查询和各类护肤品、化妆品的热门排行榜。">
	<meta property="og:description" content="瓦呐尔网为您提供91万种以上护肤品、化妆品成分数据查询和包括面部保养、眼唇护理 、唇妆 、眼眉妆 、脸部护理 、手部美甲 、香水等分类的护肤品或化妆品的热门排行榜">
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

	<!-- Page level plugin styles START -->
	<!-- IMPORT PLUGIN CSS -->
	<?php
	    if (isset($plugin_css) && is_array($plugin_css)) {
	        foreach ($plugin_css as $key => $css) {
	?>
	<link href="<?php echo base_url('assets/global/plugins/' . $css);?>" rel="stylesheet" type="text/css"/>
	<?php
	        }
	    }
	?>
	<!-- Page level plugin styles END -->
	<!-- Theme styles START -->
	<link href="<?php echo base_url('assets/global/css/components.css');?>" id="style_components" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/frontend/layout/css/style.css')?>" rel="stylesheet">  
	<!-- metronic revo slider styles -->
	<link href="<?php echo base_url('assets/frontend/layout/css/style-responsive.css')?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/frontend/layout/css/themes/blue.css')?>" rel="stylesheet" id="style-color">
	<link href="<?php echo base_url('assets/custom/styles.css')?>" rel="stylesheet">
	<!-- Theme styles END -->
	<script>
	    var site_url = "<?=site_url('/')?>";
	    var base_url = "<?=base_url('/')?>";
	</script>
</head>
<!-- Head END -->
<!-- Body BEGIN -->
<body class="ecommerce"><!-- add class page-header-fixed, if you want to fix header -->
	<!-- #be6e6e -->