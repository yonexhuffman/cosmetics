<input type="hidden" id="page_offset_num" value="0">
<input type="hidden" id="page_index" value="<?=$rating_menu_index?>">
<div class="main">
    <div class="container">
        <ul class="rating-nav">
        <?php
            foreach ($rating_menu as $key => $menu) {
                $active = '';
                if ($rating_menu_index == $key) {
                    $active = 'active';
                }
        ?>
            <li class="<?=$active?>">
                <a href="<?=site_url('rating?pageindex=' . $key)?>"><?=$menu['title']?></a>
            </li>
        <?php
            }
        ?>
        </ul>
    </div>
</div>
<div class="main">
	<div class="container">
        <ul id="ratingproductlist">
        <?php
            $i = 0;
            for ($i = 0 ; $i < count($company_list) ; $i += 2) {
                echo '<div class="row"><div class="col-md-12">';
                for($j = 0 ; $j < 2 ; $j ++) {
                    $company = $company_list[$i + $j];
                    if (empty($company['com_image']) || !file_exists('./uploads/companyimages/' . $company['com_image'])) {
                        $com_image = base_url(COMPANYDEFAULTIMAGEURL);
                    }
                    else {                    
                        $com_image = base_url('./uploads/companyimages/' . $company['com_image']);
                    }
        ?>
            <li class="product_item col-md-6">
                <a href="<?=site_url('product?companyid=' . $company['com_id'])?>">
                    <div class="raking_num pull-left" style="margin-top: 4%;">
                    <?php
                        if ($i + $j < 3) {
                    ?>
                        <img src="<?=base_url('./uploads/frontend/ratingdashboard/' . ($i + $j + 1) . '.png')?>">
                    <?php
                        }
                        else {
                            echo $i + $j + 1;
                        }
                    ?>
                    </div>
                    <div class="product_image pull-left">
                        <img src="<?=$com_image?>" style="height: 100px;" />
                    </div>
                    <div class="product_description pull-left">
                        <p class="title"><?=$company['com_name']?></p>
                        <p class="title"><?=$company['com_alias']?></p>
                        <p class="title"><?=$company['com_country']?></p>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
        <?php
                }
                echo '</div></div>';
            }
        ?>
        </ul>      
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn blue btn-block" id="loadMoreData_btn">查看更多</button>
            </div>
        </div>
	</div>
</div>