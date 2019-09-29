<div class="main">
	<div class="container product_item_detail">
    <?php
        if (isset($product['detail'])) {
            $detail = $product['detail'];
            $ingredient = $product['pro_ingredients'];
            if (empty($detail['pro_image']) || !file_exists($detail['pro_image'])) {
                $pro_image = base_url(PRODUCTDEFAULTIMAGEURL);
            }
            else {                    
                $pro_image = base_url($detail['pro_image']);
            }
    ?>
        <input type="hidden" id="blog_last_id" value="0">
        <input type="hidden" id="pro_id" value="<?=$detail['pro_id']?>">
        <div class="row myrow  product_detail_title padding-lr10 item-box">
            <h1><?=$detail['pro_title']?></h1>
        </div>  
        <div class="row myrow margin-t10 item-box">
            <div class="product_image pull-left sp-item">
                <a href="<?=$pro_image?>">
                    <img src="<?=$pro_image?>" />
                </a>
            </div>
            <div class="product_description pull-left sp-item">
                <?php echo !empty($detail['pro_title']) ? '<p class="title">化妆品名 : ' . $detail['pro_title'] . '</p>' : ''; ?>
                <?php echo !empty($detail['pro_alias']) ? '<p class="title">英文名称 : ' . $detail['pro_alias'] . '</p>' : ''; ?>
                <?php echo !empty($detail['pro_remark']) ? '<p class="title">别名 : ' . $detail['pro_remark'] . '</p>' : ''; ?>
                <?php
                    if ($login_status) {
                ?>
                    <button class="btn cosmetic-btn" id="addToFavorite">
                        <i class="fa fa-shopping-cart"></i> 收藏
                    </button>
                <?php
                    }
                ?>
            </div>
            <div class="clearfix"></div>
        </div> 
        <div class="row myrow margin-t10 product_detail_box item-box">
            <h2>成分分析</h2>
            <div id="tab_1">                
                <table class="table table-bordered ing_table" border="0">
                    <colgroup>
                        <col width="30%"></col>
                        <col width="15%"></col>
                        <col width="15%"></col>
                        <col width="15%"></col>
                        <col width="25%"></col>
                    </colgroup>
                    <thead>
                        <th>成分名称</th>
                        <th>安全风险</th>
                        <th>活性成分</th>
                        <th>致痘风险</th>
                        <th>使用目的</th>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        $good_state_img = '<img src="' . base_url(ING_GOOD_STATE_IMGURL) . '">';
                        $warning_state_img = '<img src="' . base_url(ING_WARNING_STATE_IMGURL) . '">';

                        foreach ($ingredient as $key => $ing_item) {
                            $hide_row = '';
                            if ($i > LOADDATAPERPAGE) {
                                $hide_row = 'display-hide';
                            }
                    ?>
                        <tr class="<?=$hide_row?>">
                            <td>
                                <a href="<?=site_url('ingredient/item?ing_id=' . $ing_item['ing_id'])?>"><?=$ing_item['ing_name']?></a>
                            </td>
                            <td><?=$ing_item['ing_security_risk_str']?></td>
                            <td><?=$ing_item['ing_active_str']?></td>
                            <td><?=$ing_item['ing_acne_risk_str']?></td>
                            <td><?=$ing_item['ing_usage_purpose']?></td>
                        </tr>
                    <?php
                            $i ++;
                        }
                        if ($i == 1) {
                            echo "<tr><td colspan='5'>没有结果</td></tr>";
                        }
                    ?>
                    </tbody>
                </table>
                <?php
                    if (LOADDATAPERPAGE < count($ingredient)) {
                ?>
                <div class="row text-center">
                    <button class="btn btn-success ing_expand">查看全部成分</button>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="row myrow margin-t10 product_detail_box item-box">
            <h2>安全说</h2>
            <div id="tab_2">
                <div class="row myrow padding-lr0 margin-tb10-lr0 text-center">
                        <span class="font-size17">安全星级</span> : <div class="rateit" data-rateit-value="<?=$detail['pro_rate']?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                </div>
                <div class="row myrow padding-lr0 text-center safty_btn_wrapper">
                    <div class="col-sm-6 col-md-6">
                        <button class="btn cosmetic-btn border-radius21" name="flavor_table">香精 (<?=count($product['flavor_data'])?>种)</button>
                        <button class="btn cosmetic-btn border-radius21" name="risk_table">风险成分 (<?=count($product['risk_data'])?>种)</button>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <button class="btn cosmetic-btn border-radius21" name="preservation_table">防腐剂 (<?=count($product['preservation_data'])?>种)</button>
                        <button class="btn cosmetic-btn border-radius21" name="pregantcaution_table">孕妇慎用 (<?=count($product['pregantcaution_data'])?>种)</button>
                    </div>
                </div>
                <div class="row myrow padding-lr0 margin-t10">
                    <table class="table table-bordered flavor_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($product['flavor_data'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered risk_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($product['risk_data'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered preservation_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($product['preservation_data'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>" ><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered pregantcaution_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($product['pregantcaution_data'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row myrow margin-t10 product_detail_box item-box">
            <h2>功效说</h2>
            <?php

                // var_dump($product);
            ?>
            <div id="tab_3">
                <div class="row myrow padding-lr0 text-center efficacy_btn_wrapper">
                    <div class="col-sm-6 col-md-6">
                        <button class="btn cosmetic-btn border-radius21" name="efficacy_table">主要功效成分 (<?=count($detail['pro_efficacy_ingredients'])?>种)</button>
                        <button class="btn cosmetic-btn border-radius21" name="moisturizer_table"><?php
                            if ($product['detail']['pro_cat_id'] == 1 || $product['detail']['pro_cat_id'] == 13) {
                                echo CLEANSING_LABEL . '(' . count($product['cleansing_data']) . '种)' ;
                            }
                            else {
                                echo "保湿成分(" . count($product['moisturizer_data']) . '种)' ;
                            }
                        ?>
                         </button>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <button class="btn cosmetic-btn border-radius21" name="antioxidants_table"><?php
                            if ($product['detail']['pro_cat_id'] == 1 || $product['detail']['pro_cat_id'] == 13) {
                                echo AMINOACID_LABEL . '(' . count($product['aminoacid_data']) . '种)' ;
                            }
                            else {
                                echo "抗氧化成分(" . count($product['antioxidants_data']) . '种)' ;
                            }
                        ?></button>
                        <button class="btn cosmetic-btn border-radius21" name="whitening_table"><?php
                            if ($product['detail']['pro_cat_id'] == 1 || $product['detail']['pro_cat_id'] == 13) {
                                echo SLS_SLES_LABEL . '(' . count($product['sls_sles_data']) . '种)' ;
                            }
                            else {
                                echo "美白成分(" . count($product['whitening_data']) . '种)' ;
                            }
                        ?></button>
                    </div>
                </div>
                <div class="row myrow padding-lr0 margin-t10">
                    <table class="table table-bordered efficacy_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($detail['pro_efficacy_ingredients'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered moisturizer_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            if ($product['detail']['pro_cat_id'] == 1 || $product['detail']['pro_cat_id'] == 13) {
                                foreach ($product['cleansing_data'] as $key => $efficacy_ing_id) {
                        ?>
                                <tr>
                                    <td>
                                        <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"  ><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                    </td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                                </tr>
                        <?php
                                    $i ++;
                                }
                            }
                            else 
                            foreach ($product['moisturizer_data'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"  ><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered antioxidants_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            if ($product['detail']['pro_cat_id'] == 1 || $product['detail']['pro_cat_id'] == 13) {
                                foreach ($product['aminoacid_data'] as $key => $efficacy_ing_id) {
                        ?>
                                <tr>
                                    <td>
                                        <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"  ><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                    </td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                                </tr>
                        <?php
                                    $i ++;
                                }
                            }
                            else 
                            foreach ($product['antioxidants_data'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"  ><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered whitening_table display-hide">
                        <colgroup>
                            <col width="30%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="15%"></col>
                            <col width="25%"></col>
                        </colgroup>
                        <thead>
                            <th>成分名称</th>
                            <th>安全风险</th>
                            <th>活性成分</th>
                            <th>致痘风险</th>
                            <th>使用目的</th>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            if ($product['detail']['pro_cat_id'] == 1 || $product['detail']['pro_cat_id'] == 13) {
                                foreach ($product['sls_sles_data'] as $key => $efficacy_ing_id) {
                        ?>
                                <tr>
                                    <td>
                                        <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"  ><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                    </td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                    <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                                </tr>
                        <?php
                                    $i ++;
                                }
                            }
                            else 
                            foreach ($product['whitening_data'] as $key => $efficacy_ing_id) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?=site_url('ingredient/item?ing_id=' . $ingredient[$efficacy_ing_id]['ing_id'])?>"  ><?=$ingredient[$efficacy_ing_id]['ing_name']?></a>
                                </td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_security_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_active_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_acne_risk_str']?></td>
                                <td><?=$ingredient[$efficacy_ing_id]['ing_usage_purpose']?></td>
                            </tr>
                        <?php
                                $i ++;
                            }
                            if ($i == 1) {
                                echo "<tr><td colspan='5'>没有结果</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        <?php
            if (count($product_sellers) > 0) {
        ?>
        <div class="row myrow margin-t10 product_detail_box item-box">
            <h2>购买渠道</h2>
            <div id="tab_3" style="padding-bottom: 10px;">
            <?php
                foreach ($product_sellers as $key => $seller) {
                    if (empty($seller['shoppingcat_img']) || !file_exists($shoppingcatimage_path . $seller['shoppingcat_img'])) {
                        $image_url = base_url($shoppingcatimage_path . 'default.jpg');
                    }
                    else {
                        $image_url = base_url($shoppingcatimage_path . $seller['shoppingcat_img']);
                    }
            ?>
            <div class="product_sellers_wrapper">
                <a href="<?=$seller['shop_url']?>" class="go_shop" seller-id="<?=$seller['seller_id']?>" >
                    <div class="seller_cat_image pull-left">
                        <img src="<?=$image_url?>" class="frontendproduct_seller_category_image">
                    </div>
                    <div class="seller_name pull-left"><?=$seller['shop_name']?></div>
                    <div class="seller_price pull-left"><?=$seller['price']?> &#20803;</div>
                    <div class="clearfix"></div>
                </a>
            </div>
            <?php
                }
            ?>
            </div>
        </div>
        <?php
            }
        ?>  
        <div class="row myrow item-box margin-t10 product_detail_box margin-b10" id="blog_wrapper">
            <h2>用户点评</h2> 
            <?php
                if ($login_status) {
            ?>
            <a class="btn cosmetic-btn pull-right" href="javascript:void(0);" id="blog_btn">写评论</a>
            <?php
                }
            ?>
            <div class="commment-box form">
                <form method="POST" enctype="multipart/form-data" id="form_send_comment" action="<?=site_url('product/savecomment')?>">
                    <input type="hidden" name="b_id" value="">
                    <input type="hidden" name="pro_id" value="<?=$pro_id?>">
                    <div class="row margin-t10">
                        <div class="col-sm-12 col-md-12 form-horizontal">
                            <!-- <div class="form-group">
                                <label class="control-label col-md-3">题目</label>
                                <div class="col-md-9">
                                    <input type="text" name="b_title" class="form-control" >
                                </div>
                            </div> -->
                            <div class="form-group" style="display: flex;align-items: center;">
                                <label class="control-label col-md-3" style="padding-top: 0;">评价分数</label>
                                <div class="col-md-9">
                                    <input type="range" value="5" step="0.25" name="b_user_rate" id="b_user_rate">
                                    <div class="rateit" data-rateit-readonly="false" data-rateit-backingfld="#b_user_rate" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">内容</label>
                                <div class="col-md-9">
                                    <textarea name="b_content" class="form-control" rows="11"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <span class="btn cosmetic-btn  fileinput-button pull-right">
                                    <i class="fa fa-file-picture-o"></i>
                                    <span>
                                    </span>
                                    <input type="file" name="comment_image">
                                    </span>
                                </div>
                                <div class="col-md-9">
                                    <img id="preview_image" src="#" class="product_image" style="width: 100%;display: none;">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="button" id="send_comment" class="btn btn-circle cosmetic-btn"><i class="fa fa-save"></i> 发布</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="blog_list_view">
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn blue cosmetic-btn" id="loadMoreData_btn" style="margin: 10px 0px;">查看更多</button>
                </div>
            </div>
        </div>
        
    <?php
        }
    ?>
	</div>
</div>