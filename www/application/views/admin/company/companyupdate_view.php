<div class="row" style="margin: 0;">
	<div class="col-md-12 form">
	<form class="form-horizontal new_company_form" role="form" method="POST" action="<?=site_url('admin/company/insert')?>" enctype="multipart/form-data">
		<input type="hidden" name="com_id" value="<?php echo isset($com_id) ? $com_id : -1;?>">
		<input type="hidden" name="prev_com_image" value="<?php echo isset($company_data['com_image']) ? $company_data['com_image'] : '';?>">
		<div class="form-body">
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-md-7">
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 品牌名称<span class="required">*</span> </label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="品牌名称" name="com_name" value="<?php echo isset($company_data['com_name']) ? $company_data['com_name'] : '';?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 英文名<span class="required">*</span></label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="英文名" name="com_alias" value="<?php echo isset($company_data['com_alias']) ? $company_data['com_alias'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 国家</label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="国家" name="com_country" value="<?php echo isset($company_data['com_country']) ? $company_data['com_country'] : '';?>">
						</div>
					</div>	
				</div>
				<div class="col-md-4 text-center">
					<?php
						if (isset($company_data['com_image'])) {
							if (empty($company_data['com_image']) || !file_exists($image_path . $company_data['com_image'])) {
								$image_url = base_url(COMPANYDEFAULTIMAGEURL);
							}
							else {
								$image_url = base_url($image_path . $company_data['com_image']);
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
							图片 </span>
							<input type="file" name="com_image">
							</span>
						</div>
						<div class="col-md-12 product_image_preview">
							<img id="preview_image" src="#" class="product_image display-hide">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 保存</button>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>