<div class="fancy-container form">
	<form method="POST" enctype="multipart/form-data" id="form_send_comment" action="<?=site_url('product/saveblog')?>">
		<input type="hidden" name="pro_id" value="<?=$pro_id?>">
		<div class="row myrow">
			<div class="col-sm-12 col-md-12 form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 col-md-4 control-label"> 分数</label>
					<div class="col-sm-7 col-md-7" style="padding-top: 9px;">
						<input type="range" name="b_user_rate" value="4" step="0.25" id="backing5">
						<div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">题目</label>
					<div class="col-md-8">
						<input type="text" name="b_title" class="form-control" >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">分类</label>
					<div class="col-md-8">
						<div class="md-checkbox-inline">
					<?php
						foreach ($tags as $key => $tag) {
					?>
							<div class="md-checkbox col-md-4">
								<input type="checkbox" id="checkbox<?php echo $key; ?>" name="tags[]" class="md-check" value="<?php echo $tag?>">
								<label for="checkbox<?php echo $key; ?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?php echo $tag?>
								</label>
							</div>
					<?php
						}
					?>	
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">评价内容</label>
					<div class="col-md-8">
						<textarea name="b_content" class="form-control" rows="11"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-4 text-right">
						<span class="btn green fileinput-button">
						<i class="fa fa-file-picture-o"></i> 晒图
						<span>
						</span>
						<input type="file" name="comment_image">
						</span>
					</div>
					<div class="col-md-8">
						<img id="preview_image" src="#" class="product_image display-hide" style="width: 100%;">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="button" id="send_comment" class="btn btn-circle btn-success"><i class="fa fa-save"></i> 发布</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script src="<?php echo base_url('assets/global/plugins/rateit/src/jquery.rateit.js')?>" type="text/javascript"></script>