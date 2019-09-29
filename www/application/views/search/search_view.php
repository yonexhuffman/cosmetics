<style type="text/css">
    /* BEGIN min width 1025px */
    @media (min-width: 1025px) {
        .search_wrapper{
            margin-top: 23%;
        }
		.page-content{
			background: #ebf7f9;
		}
    }
    /* END min width 1025px */
    /* BEGIN min width 1025px */
    @media (max-width: 1024px) {
        .search_wrapper{
            margin-top: 42%;
        }
		.page-content{
			background: #ebf7f9;
		}
    }    
</style>
<div class="main">
	<div class="main-banner">
		<div class="container">
			<div class="row section1">
				<div class="col-md-offset-3 col-sm-12 col-md-9 search_wrapper">
					<div>
						<div id="search-tab-choose">
							<span class="active" name="product">产品</span>
							<span name="ingredient">成分</span>
						</div>
					</div>
					<div>
						<div class="main-banner-title-search-center pull-left">
							<!-- <input id="search_form" class="form-control" autofocus="autofocus" type="text" value="" placeholder="搜索 <?php echo isset($product_total_count) ? $product_total_count : '0'; ?> 种化妆品"> -->
							<input id="search_form" class="form-control" autofocus="autofocus" type="text" value="" placeholder="搜索 911,690 种化妆品">
						</div>
						<div class="main-banner-title-search-right pull-left" id="btn_search">
							<span>
								<i class="fa fa-search"></i>
							</span>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="fav-search">
						<ul>
							<?php
							$i = 0;
							foreach ($fav_keys as $keyword) {
							?>
							<li>
								<a href="<?=site_url().'product?keyword='.$keyword?>"><?=$keyword?></a>
							</li>
							<?php	
								$i ++;
								if ($i > 7) {
									break;
								}
							}
							?>
							<?php
							$i = 0;
							foreach ($fav_cat as $cat) {
							?>
							<li>
								<a href="<?=site_url('product?category=' . $cat['cat_new_id'])?>"><?=$cat['cat_new_name']?></a>
							</li>
							<?php	
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="container">
		<div class="main-content">
				
				   
		</div>
	</div>
</div>