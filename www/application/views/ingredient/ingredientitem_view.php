<div class="main">
  <div class="container">


      <!-- <div id="product-search-wrapper">
        <div class="search-box-left">
          <div class="search-box-left-btn search-button">
            <span class="search-text">成分</span>
          </div>
        </div>         
        <div class="search-box-right">
          <input id="search_form" type="text" value="" autofocus="autofocus" value="<?php echo isset($keyword) ? $keyword : ''; ?>" placeholder="搜索 <?php echo isset($ingredient_total_count) ? $ingredient_total_count : ''; ?> 成分" tname="product">
        </div>
        <div class="search-box-button" id="btn_search">
            <img class="" src="https://img1.bevol.cn/pc/images/pcpicture/search-icon-ccc.png">
        </div>
        <div class="clearfix"></div>
      </div> -->

    <div class="row ingredient_detail_wrapper myrow item-box">
        <h1><?=$ingredient['ing_name']?></h1>
    </div>
    <div class="row ingredient_detail_wrapper myrow item-box margin-top margin-bottom10">
        <div class="row myrow border-top padding-top-6">
            <div class="col-sm-6 col-md-6 padding0">
                <div class="col-sm-12 col-md-12 mycol">
                    <span class="bold cosmetic-clr">成分名称</span> : <?=$ingredient['ing_name']?>
                </div>
                <div class="col-sm-12 col-md-12 mycol">
                    <span class="bold cosmetic-clr">英文名称</span> : <?=$ingredient['ing_alias']?>
                </div>
                <div class="col-sm-12 col-md-12 mycol">
                    <span class="bold cosmetic-clr">成分别名</span> : <?=$ingredient['ing_remark']?>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 padding0">
                <div class="col-sm-12 col-md-12 mycol">
                    <span class="bold cosmetic-clr">CAS号</span> : <?=$ingredient['ing_csano']?>
                </div>
                <div class="col-sm-12 col-md-12 mycol">
                    <span class="bold cosmetic-clr">使用目的</span> : <?=$ingredient['ing_usage_purpose']?>
                </div>
                <div class="col-sm-12 col-md-12 mycol">
                    <span class="bold cosmetic-clr">安全风险</span> : <?=$ingredient['ing_security_risk']?>
                </div>
            </div>
        </div>
        <div class="row myrow border-top">
            <div class="col-sm-12 col-md-12 mycol">
                <span class="bold cosmetic-clr">成分简介</span>
            </div>
            <div class="col-sm-12 col-md-12 mycol">
                <?=$ingredient['ing_overview']?>
            </div>
        </div>
        <div class="row myrow border-top">
            <div class="col-sm-12 col-md-12 mycol">
                <span class="bold cosmetic-clr">含有此成分的产品</span>
            </div>
            <?php
                if (count($ing_products) > 0) {
                    $i = 1;
                    foreach ($ing_products as $key => $item) {
            ?>
            <div class="col-sm-12 col-md-12 mycol">
                <?=$i?>. <a class="ing_products" href="<?=site_url('product/item?pro_id=' . $item['pro_id'])?>"><?php echo $item['pro_title'];?></a>
            </div>
            <?php
                        $i ++;
                    }
                }
            ?>
            <div class="col-sm-12 col-md-12 mycol more-box">
                <a href="<?=site_url('product?ingredient=' . $ing_id)?>" class="btn more-btn cosmetic-btn">查看更多</a>
            </div>
        </div>
      </div>
        <div class="product_item_detail">
            <input type="hidden" id="blog_last_id" value="0">
            <input type="hidden" id="ing_id" value="<?=$ingredient['ing_id']?>">
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
                    <form method="POST" enctype="multipart/form-data" id="form_send_comment" action="<?=site_url('ingredient/savecomment')?>">
                        <input type="hidden" name="b_id" value="">
                        <input type="hidden" name="ing_id" value="<?=$ing_id?>">
                        <div class="row margin-t10">
                            <div class="col-sm-12 col-md-12 form-horizontal">
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
        </div>
	</div>
</div>