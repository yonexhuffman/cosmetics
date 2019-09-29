<div class="row" style="max-width: 800px;width: 800px;">
	<div class="col-md-12 form">
	<form class="form-horizontal new_product_form" role="form" method="POST" action="<?=site_url('admin/product/insert')?>" enctype="multipart/form-data">
		<input type="hidden" name="op_id" value="<?php echo isset($op_id) ? $op_id : -1;?>">
		<div class="form-body">
			<div class="row" style="margin: 0px;">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 用户 </label>
						<div class="col-sm-8 col-md-8" style="padding-top: 9px;">
							<?php echo isset($opinions_data['user_nickname']) ? $opinions_data['user_nickname'] : '';?>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 内容</label>
						<div class="col-sm-8 col-md-8" style="padding-top: 9px;text-align: justify;text-indent: 10px;">
							<?php echo isset($opinions_data['content']) ? $opinions_data['content'] : '';?>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 反馈日期</label>
						<div class="col-sm-8 col-md-8" style="padding-top: 9px;">
							<?php echo isset($opinions_data['send_datetime']) ? $opinions_data['send_datetime'] : '';?>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</form>
	</div>
</div>