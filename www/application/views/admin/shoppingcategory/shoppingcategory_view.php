<div class="row">
	<div class="col-md-12">
		<div class="col-sm-12 col-md-offset-2 col-md-8 portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i> 添加
				</div>
				<div class="tools">
					<a href="" class="expand" data-original-title="" title="">
					</a>
				</div>
			</div>
			<div class="portlet-body form" style="display: none;">
				<form class="form-horizontal new_shoppingcategory_form" role="form" method="POST" action="<?=site_url('admin/shoppingcategory/insert')?>" enctype="multipart/form-data">
					<input type="hidden" name="shop_cat_id" value="-1">
					<div class="form-body">
						<div class="form-group">
							<label class="col-sm-4 col-md-4 control-label">商城名</label>
							<div class="col-sm-7 col-md-7">
								<input type="text" class="form-control" placeholder="Category Name" name="shoppingcat_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 col-md-4 control-label">图片</label>
							<div class="col-sm-7 col-md-7">
								<input type="file" class="form-control" name="shoppingcat_img">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 col-md-4 control-label">排序</label>
							<div class="col-sm-7 col-md-7">
								<input type="text" class="form-control" placeholder="Display Order Num" name="disp_order_num">
							</div>
						</div>
					</div>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12 text-center">
								<button type="submit" class="btn green">保存</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-sm-12 col-md-offset-2 col-md-8" style="padding: 0px;">
			<table class="table table-bordered">
				<thead>
					<th>序号</th>
					<th>图片</th>
					<th>商城名</th>
					<th>排序</th>
					<th></th>
				</thead>
				<tbody>
				<?php
					$i = 1;
					if (count($data) > 0) {
						foreach ($data as $key => $record) {
				?>
					<tr shop-cat-id="<?=$record['shop_cat_id']?>" image-name="<?=$record['shoppingcat_img']?>">
						<td><?=$i?></td>
						<td>
							<img src="<?=base_url($img_path . $record['shoppingcat_img'])?>" width="70">
						</td>
						<td><?=$record['shoppingcat_name']?></td>
						<td><?=$record['disp_order_num']?></td>
						<td>
							<button class="btn btn-sm btn-success btn-update">
								<i class="fa fa-edit"></i>
							</button>
							<button class="btn btn-sm btn-danger btn-delete">
								<i class="fa fa-trash"></i>
							</button>
						</td>
					</tr>
				<?php
							$i ++;
						}
					}
					else {
						echo "<tr><td colspan='5'>Empty Data</td></tr>";
					}
				?>
				</tbody>
			</table>
		</div>			
	</div>
</div>