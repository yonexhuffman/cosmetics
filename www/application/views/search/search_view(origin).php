<!-- BEGIN SLIDER -->
<!-- <div class="page-slider margin-bottom-35">
    <div id="layerslider" style="width: 100%; height: 494px; margin: 0 auto;">
        <?php
            $transition2d = array(
                'transition2d: 24,25,27,28;' , 
                'transition2d: 110,111,112,113;' , 
                'transition2d: 92,93,105;' , 
                'transition2d: 110,111,112,113;' , 
            );
            $slider_imgs = get_filenames('./uploads/frontend/dashboardslider');
            foreach ($slider_imgs as $key => $img) {
        ?>
        <div class="ls-slide ls-slide<?=($key + 1)?>" data-ls="offsetxin: right; slidedelay: 7000; <?=$transition2d[($key % count($transition2d))]?>">
            <img src="<?=base_url('./uploads/frontend/dashboardslider/' . $img)?>" class="ls-bg" alt="Slide background">
        </div>
        <?php
            }
        ?>
    </div>
</div> -->
<!-- END SLIDER -->
<style type="text/css">
    /* BEGIN min width 1025px */
    @media (min-width: 1025px) {
        .search_wrapper{
            margin-top: 20%;
        }
    }
    /* END min width 1025px */
    /* BEGIN min width 1025px */
    @media (max-width: 1024px) {
        .search_wrapper{
            margin-top: 42%;
        }
    }    
</style>
<div class="main">
	<div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-sm-12 col-md-6 search_wrapper">
                <div>
                    <div id="search-tab-choose">
                        <span class="active" name="product">产品</span>
                        <span name="ingredient">成分</span>
                    </div>
                </div>
                <div>
                    <div class="main-banner-title-search-center pull-left">
                        <input id="search_form" class="form-control" autofocus="autofocus" type="text" value="" placeholder="搜索 <?php echo isset($product_total_count) ? $product_total_count : '0'; ?> 种化妆品">
                    </div>
                    <div class="main-banner-title-search-right pull-left" id="btn_search">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
	</div>
</div>