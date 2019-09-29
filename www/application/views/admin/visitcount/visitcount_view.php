<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered table-hover" id="data_ajaxtable">
			<colgroup>
				<col width="7%"></col>
				<col width="28%"></col>
				<col width="15%"></col>
				<col width="15%"></col>
				<col width="15%"></col>
				<col width="10%"></col>
				<!-- <col width="10%"></col> -->
			</colgroup>
			<thead>
				<tr role="row" class="heading">
					<th>序号</th>
					<th>化妆品名称</th>
					<th>商城名</th>
					<th>商店名称</th>
					<th>价格</th>
					<th>查看次数</th>
				</tr>
				<tr role="row" class="filter">
					<td></td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="pro_title">
					</td>
					<td>
						<select name="shop_cat_id" class="form-control form-filter input-sm">
							<option value="">请选择...</option>
						<?php
							foreach ($category as $key => $cat_item) {
						?>
							<option value="<?=$cat_item['shop_cat_id']?>"><?=$cat_item['shoppingcat_name']?></option>
						<?php
							}
						?>
						</select>
					</td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="shop_name">
					</td>
					<td></td>
					<td>
						<div class="pull-left">
							<button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i></button>
						</div>
						<div class="pull-right">
							<button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i></button>
						</div>
						<div class="clearfix"></div>
					</td>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>	
</div>