<!-- BEGIN HEADER -->
<div class="header">
	<div class="container">
		<a class="site-logo" href="<?=site_url('')?>"><img src="<?php echo base_url(FRONTENDLOGOIMGURL)?>" alt="Metronic FrontEnd" height="45" ></a>

		<a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
		<!-- BEGIN NAVIGATION -->
		<div class="header-navigation pull-right font-transform-inherit">
			<ul>
            <?php
                foreach ($menu as $key => $menu_item){
                  $url = $menu_item['url'];
            ?>
                <li class="<?php if($page_key == $key) echo "active"; ?>">
                    <a href="<?=site_url($url)?>"><?=$menu_item['title']?></a>
                </li>
            <?php
                }
                if ($LOGINSTATUS) {
            ?>
                <li class="<?php if($page_key == 5) echo "active"; ?>">
                    <a href="<?=site_url('/dashboard')?>">我的</a>
                </li>
                <li class="<?php if($page_key == 6) echo "active"; ?>">
                    <a href="<?=site_url('/login/signUp')?>">退出</a><!--fire 注销 -->
                </li>
            <?php
                }
                else {
            ?>
                <li class="<?php if($page_key == 6) echo "active"; ?>">
                    <a href="<?=site_url('/login')?>">登录</a>
                </li>
            <?php
                }
            ?>     
			</ul>
		</div>
		<!-- END NAVIGATION -->
	</div>
</div>
<!-- Header END -->
<div class="page-content">

<?php
    if ($page_key!=1 && $page_key!=6) {
?>
    <div class="main">
        <div class="container">
            <div class="crumbs_nav">
                <h1 class="crumbs_nav_text"><a href="<?=site_url('')?>" target="_self">首页</a> / 
        <?php
            foreach ($menu as $key => $menu_item) {
                // var_dump($menu_item);
                if ($page_key == $key) echo $menu_item['title'];
            }
            // die();
        ?>
                </h1>
            </div>            
        </div>
    </div>
<?php
    }
?>