<input type="hidden" id="page_offset_num" value="0">
<input type="hidden" id="page_index" value="<?=$rating_menu_index?>">
<input type="hidden" id="cat_id" value="<?php echo isset($cat_id) ? $cat_id : ''; ?>">
<div class="main">
    <div class="container">
        <div class="cosmetic-wrapper">
        <!-- <ul class="rating-nav">
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
        </ul> -->
        <div class="dropdown sp-show">
            <button class="dropbtn cosmetic-btn">&nbsp;&nbsp;&nbsp;类&nbsp;&nbsp;&nbsp;别&nbsp;&nbsp;&nbsp;</button>
            <div class="dropdown-content">
                <a href="<?=site_url('rating')?>" class="<?php echo isset($cat_id) ? '' : 'active'; ?>">整体</a>
            <?php
                foreach ($product_category as $key => $category) {
                    $active = '';
                    if (isset($cat_id) && $cat_id == $category['cat_new_id']) {
                        $active = 'active';
                    }
                    $seperater = '';
                    if ($category['cat_new_parent_id'] > 0) {
                        $seperater = str_repeat('&nbsp;' , 5);
                    }
            ?>
                <a href="<?=site_url('rating?category=' . $category['cat_new_id'])?>" class="<?=$active?>"><?=$seperater . $category['cat_new_name']?></a>
            <?php
                }
            ?>
            </div>
        </div>


      <div class="goods-main-box col-nav goods-category sp-hide">
        <ul>
          <?php
            foreach ($top_categories as $key => $top_category) {
              $active = '';
              if (isset($cat_id) && $cat_id == $top_category['cat_new_id']) {
                  $active = 'active';
              }
              if (isset($top_id) && $top_id == $top_category['cat_new_id']) {
                  $active = 'active';
              }
          ?>
          <li class="padding-r10-b20">
            <a target="_self" href="<?=site_url('rating?category=' . $top_category['cat_new_id'])?>" class="<?=$active?>">
              <?=$top_category['cat_new_name']?>
            </a>
          </li>
          <?php
            }
          ?>
          <div class="clearfix"></div>
        </ul>
      </div>

      <?php
        if (isset($sub_categories)) {
      ?>

      <div class="goods-sub-box col-nav sp-hide">
        <ul>
          <?php
            foreach ($sub_categories as $key => $sub_category) {
              $active = '';
              if (isset($cat_id) && $cat_id == $sub_category['cat_new_id']) {
                  $active = 'active';
              }
          ?>
          <li class="padding-r10-b20">
            <a target="_self" href="<?=site_url('rating?category=' . $sub_category['cat_new_id'])?>" class="<?=$active?>">
              <?=$sub_category['cat_new_name']?>
            </a>
          </li>
          <?php
            }
          ?>
          <div class="clearfix"></div>
        </ul>
      </div>

      <?php
        }
      ?>

        <ul id="ratingproductlist">
        <?php
            $i = 0;
            for ($i = 0 ; $i < count($product_list) ; $i++) {
                echo '<div class="row"><div class="col-md-12">';
                    if (!isset($product_list[$i])) {
                        break;
                    }
                    $product = $product_list[$i];
                    if (empty($product['pro_image']) || !file_exists($product['pro_image'])) {
                        $pro_image = base_url(PRODUCTDEFAULTIMAGEURL);
                    }
                    else {                    
                        $pro_image = base_url($product['pro_image']);
                    }
        ?>
            <li class="product_item">
                <a href="<?=site_url('product/item?pro_id=' . $product['pro_id'])?>"  >
                    <div class="raking_num pull-left">
                    <?php
                        if ($i < 3) {
                    ?>
                        <img  src="<?=base_url('./uploads/frontend/ratingdashboard/' . ($i + 1) . '.png')?>">
                    <?php
                        }
                        else {
                            echo '<p>'.($i + 1).'</p>';
                        }
                    ?>
                    </div>
                    <div class="product_image pull-left">
                        <img src="<?=$pro_image?>" />
                    </div>
                    <div class="product_description pull-left">
                        <p class="title"><?=$product['pro_title']?></p>
                        <p class="alias"><?=$product['pro_alias']?></p>
                        <div class="rateit" data-rateit-value="<?=$product['pro_rate']?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
        <?php
                // }
                echo '</div></div>';
            }
        ?>
        </ul>  
        <?php            
            if (count($product_list) == 0) {
        ?>
            <div class="note note-danger">
                <p>
                    没有结果
                </p>
            </div>
        <?php
            }
            else {
        ?>
        <div class="row">
            <div class="col-md-12 text-center more-box">
                <button class="btn more-btn cosmetic-btn" id="loadMoreData_btn">查看更多</button>
            </div>
        </div>
        <?php
            }
        ?> 
        </div>
	</div>
</div>