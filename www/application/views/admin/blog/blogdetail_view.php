<style type="text/css">
</style>
<input type="hidden" id="blog_last_id" value="<?php echo (isset($blog_list) && (count($blog_list) > 0)) ? $blog_list[count($blog_list) - 1]['b_id'] : '-1'; ?>">
<input type="hidden" id="pro_id" value="<?php echo isset($pro_id) ? $pro_id : '0'; ?>">
<div class="row">
	<div class="col-md-12">
		<div class="row" style="margin-top: 10px;">
			<div class="col-sm-12 col-md-offset-2 col-md-8">
				<div class="product_info_view">
					<p class="label_cate text-right">化妆品名称 : </p>
					<p class="content text-left"><?php echo isset($product_data) ? $product_data['pro_title'] : '' ?></p>
				</div>
				<div class="product_info_view">
					<p class="label_cate text-right">英文名称 : </p>
					<p class="content text-left"><?php echo isset($product_data) ? $product_data['pro_alias'] : '' ?></p>
				</div>
				<div class="product_info_view">
					<p class="label_cate text-right">别名 : </p>
					<p class="content text-left"><?php echo isset($product_data) ? $product_data['pro_remark'] : '' ?></p>
				</div>
				<div class="product_info_view">
					<p class="label_cate text-right">类别 : </p>
					<p class="content text-left"><?php echo isset($product_data) ? $product_data['cat_name'] : '' ?></p>
				</div>
				<div class="product_info_view">
					<p class="label_cate text-right">安全星级 : </p>
					<div class="content text-left">
						<input type="range" name="pro_rate" value="<?php echo isset($product_data) ? $product_data['pro_rate'] : '0' ?>" step="0.25" id="backing5">
						<div class="rateit" data-rateit-readonly="true" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5"></div>
					</div>
				</div>
			</div>
		</div>	
		<div class="row" style="margin-top: 10px;">
			<div class="col-sm-12 col-md-12" id="blog_list_view">
			<?php
				foreach ($blog_list as $key => $blog) {
	            $avatar_image = base_url(DEFAULT_AVATAR_IMGURL);
	            if (!empty($blog['acc_image']) && file_exists($avatar_upload_path . $blog['acc_image'])) {
	                $avatar_image = base_url($avatar_upload_path . $blog['acc_image']);
	            }
			?>
                <div class="xxs-info-box line">
                	<div class="blog-content" blog-id="<?=$blog['b_id']?>">
	                    <div class="xxs-info-title">
	                        <div class="xxs-info-title-img">
	                            <img src="<?=$avatar_image?>" class="img-circle">
	                        </div>
	                        <div class="xxs-info-title-main">
	                            <p class="p1"><?=$blog['user_id']?></p>
	                            <div class="p2"><?=$blog['b_tags']?></div>
	                        </div>
	                        <div class="clear"></div>
	                    </div>
	                    <div class="xxs-info-content"><?=$blog['b_content']?></div>
						<input type="range" class="b_user_rate" value="<?=$blog['b_user_rate']?>" step="0.25" id="backing_<?=$blog['b_id']?>">
						<div class="rateit" data-rateit-readonly="false" data-rateit-backingfld="#backing_<?=$blog['b_id']?>" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5"></div>
	                    <div class="row">
	                    	<div class="col-md-12 text-right">
	                    		<button class="btn btn-success btn_update">更新</button>
	                    		<button class="btn btn-danger btn_delete">删除</button>
	                    	</div>
	                    </div>
	                </div>
					<?php echo isset($blog['commentHtml']) ? $blog['commentHtml'] : ''; ?>
                </div>
            <?php
				}
			?>
			</div>
		</div>		
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12 text-center">
				<img src="<?=base_url(LOADING_GIF_FILE_URL)?>" width="100" id="loadMoreData_icon" style="<?php echo (count($blog_list) < LOADDATAPERPAGE) ? 'display: none;' : '' ; ?>">
			</div>
		</div>
	</div>	
</div>