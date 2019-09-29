<div class="row" style="margin: 0;">
	<div class="col-md-12 form">
		<div class="note note-success">
			<p>
				添加成分时首先搜索要添加的成分，保存时请按Ctrl键选择要保存的成分。
			</p>
			<p>
				<span style="color: #d00;">*</span> 标记的行是必须得输入的行.
			</p>
		</div>
	<form class="form-horizontal new_product_form" role="form" method="POST" action="<?=site_url('admin/product/insert')?>" enctype="multipart/form-data">
		<input type="hidden" name="pro_id" value="<?php echo isset($pro_id) ? $pro_id : -1;?>">
		<input type="hidden" name="prev_pro_image" value="<?php echo isset($product_data['pro_image']) ? $product_data['pro_image'] : '';?>">
		<div class="form-body">
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-md-7">
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 化妆品名称<span class="required">*</span> </label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="化妆品名称" name="pro_title" value="<?php echo isset($product_data['pro_title']) ? $product_data['pro_title'] : '';?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 英文名称<span class="required">*</span></label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="英文名称" name="pro_alias" value="<?php echo isset($product_data['pro_alias']) ? $product_data['pro_alias'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 别名</label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="别名" name="pro_remark" value="<?php echo isset($product_data['pro_remark']) ? $product_data['pro_remark'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 类别<span class="required">*</span></label>
						<div class="col-sm-7 col-md-7">
							<select class="form-control" name="pro_cat_new_id">
								<option></option>
							<?php
								foreach ($product_category as $key => $cate_item) {
									$selected = '';
									if ($cate_item['cat_new_id'] < 0) {
										continue;
									}
									if (isset($product_data['pro_cat_new_id']) && $product_data['pro_cat_new_id'] == $cate_item['cat_new_id']) {
										$selected = 'selected';
									}
							?>
								<option value="<?=$cate_item['cat_new_id']?>" <?=$selected?> ><?=$cate_item['cat_new_name']?></option>
							<?php
								}
							?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 安全星级</label>
						<div class="col-sm-7 col-md-7" style="padding-top: 9px;">
							<input type="range" name="pro_rate" value="<?php echo isset($product_data['pro_rate']) ? $product_data['pro_rate'] : '4';?>" step="0.25" id="backing5">
							<div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
							</div>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 制造商</label>
						<div class="col-sm-7 col-md-7" style="padding-top: 9px;">
							<p id="company_name">
								<?php echo isset($company_data['com_name']) ? $company_data['com_name'] . '(' . $company_data['com_alias'] . ')' : '';?>
							</p>
							<input type="hidden" id="pro_company_id" name="pro_company_id" value="<?php echo isset($product_data['pro_company_id']) ? $product_data['pro_company_id'] : '';?>">
							<input type="hidden" id="pro_company_load_remote_data" class="form-control select2">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 成分选择</label>
						<div class="col-sm-7 col-md-7">
							<input type="hidden" id="pro_ingredients_load_remote_data" class="form-control select2">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 成分名称	<span class="required">*</span></label>
						<div class="col-sm-7 col-md-7">
							<select multiple="multiple" class="multi-select" id="pro_ingredients" name="pro_ingredients[]">
							<?php
								foreach ($pro_ingredients as $key => $ingredient) {
							?>
								<option value="<?=$ingredient['ing_id']?>" selected><?=$ingredient['ing_name']?></option>
							<?php
								}
							?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label">主要功效成分</label>
						<div class="col-sm-7 col-md-7">
							<select multiple="multiple" class="multi-select" id="pro_efficacy_ingredients" name="pro_efficacy_ingredients[]">
							<?php
								$efficacy_ing_ids = explode(',' , $product_data['pro_efficacy_ingredients']);
								$efficacy_ing_ids = array_slice(array_slice($efficacy_ing_ids, 1), 0 , count($efficacy_ing_ids) - 2);
								foreach ($pro_ingredients as $key => $ingredient) {
									$selected = '';
									if (in_array($ingredient['ing_id'], $efficacy_ing_ids)) {
										$selected = 'selected';
									}
							?>
								<option value="<?=$ingredient['ing_id']?>" <?=$selected?> ><?=$ingredient['ing_name']?></option>
							<?php
								}
							?>
							</select>
						</div>
					</div>	
				</div>
				<div class="col-md-4 text-center">
					<?php
						if (isset($product_data['pro_image'])) {
							if (empty($product_data['pro_image']) || !file_exists($product_data['pro_image'])) {
								$image_url = base_url('./uploads/default.png');
							}
							else {
								$image_url = base_url($product_data['pro_image']);
							}
					?>
					<a href="<?=$image_url?>" data-rel="fancybox-button" class="fancybox-button">
						<img src="<?=$image_url?>" class="product_image" style="" />
					</a>
					<?php
						} 
					?>
					<div class="row">
						<div class="col-md-12">
							<span class="btn green fileinput-button">
							<i class="fa fa-file-picture-o"></i>
							<span>
							化妆品图片 </span>
							<input type="file" name="pro_image">
							</span>
						</div>
						<div class="col-md-12 product_image_preview">
							<img id="preview_image" src="#" class="product_image display-hide">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-sm-2 col-md-2 control-label">购买渠道</label>
						<div class="col-sm-9 col-md-9">
							<table class="table table-bordered" id="sellers_table">
								<colgroup>
									<col width="20%"></col>
									<col width="20%"></col>
									<col width="40%"></col>
									<col width="10%"></col>
									<col width="10%"></col>
								</colgroup>
								<thead>
									<th>商城名</th>
									<th>商店名称</th>
									<th>链接地址</th>
									<th>价格</th>
									<th>删除</th>
								</thead>
								<tbody>
								<?php
									if (isset($product_sellers)) {
										foreach ($product_sellers as $key => $seller) {
								?>
									<tr>
										<input type="hidden" name="update_seller_id[]" value="<?=$seller['seller_id']?>">
										<td>
											<select class="form-control" name="shop_cat_id[]">
												<option></option>
											<?php
												foreach ($shopping_category as $key => $shopping_cat_item) {
													$selected = '';
													if ($seller['shop_cat_id'] == $shopping_cat_item['shop_cat_id']) {
														$selected = 'selected';
													}
											?>
												<option value="<?=$shopping_cat_item['shop_cat_id']?>" <?=$selected?>><?=$shopping_cat_item['shoppingcat_name']?></option>
											<?php
												}
											?>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" name="shop_name[]" value="<?=$seller['shop_name']?>">
										</td>
										<td>
											<input type="text" class="form-control" name="shop_url[]" value="<?=$seller['shop_url']?>">
										</td>
										<td>
											<input type="text" class="form-control" name="price[]" value="<?=$seller['price']?>">
										</td>
										<td>
											<button class="btn btn-sm btn-danger del_seller_row"><i class="fa fa-trash"></i></button>
										</td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-right">
											<button type="button" class="btn btn-primary add_seller_row">
												<i class="fa fa-plus"></i>
											</button>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 保存</button>
					<a href="<?=site_url('/admin/product/')?>" class="btn btn-default"><i class="fa fa-mail-reply"></i> 返回</a>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>