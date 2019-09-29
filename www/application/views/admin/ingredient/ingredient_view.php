<div class="row">
	<div class="col-md-12">
		<div class="row ">
			<div class="col-md-12 text-right">
				<a href="<?=site_url('/admin/ingredient/update')?>" class="btn btn-success"><i class="fa fa-plus"></i> 添加</a>
			</div>
		</div>
		<table class="table table-striped table-bordered table-hover" id="data_ajaxtable">
			<colgroup>
				<col width="5%"></col>
				<col width="15%"></col>
				<col width="12%"></col>
				<col width="10%"></col>
				<col width="9%"></col>
				<col width="9%"></col>
				<col width="9%"></col>
				<col width="9%"></col>
				<col width="9%"></col>
				<col width="13%"></col>
			</colgroup>
			<thead>
				<tr role="row" class="heading">
					<th>序号</th>
					<th>成分名称</th>
					<th>CAS号</th>
					<th>安全风险</th>
					<th>活性成分</th>
					<th>致痘风险</th>
					<th>香精</th>
					<th>防腐剂</th>
					<th>孕妇慎用</th>
					<th></th>
				</tr>
				<tr role="row" class="filter">
					<td></td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="ing_name">
					</td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="ing_csano">
					</td>
					<td></td>
					<td>
						<select name="ing_active" class="form-control form-filter input-sm">
							<option value="">Select...</option>
						<?php
							foreach ($is_active as $key => $item) {
						?>
							<option value="<?=$key?>"><?=$item?></option>
						<?php
							}
						?>
						</select>
					</td>
					<td>
						<select name="ing_acne_risk" class="form-control form-filter input-sm">
							<option value="">Select...</option>
						<?php
							foreach ($is_active as $key => $item) {
						?>
							<option value="<?=$key?>"><?=$item?></option>
						<?php
							}
						?>
						</select>
					</td>
					<td>
						<select name="ing_flavor" class="form-control form-filter input-sm">
							<option value="">Select...</option>
						<?php
							foreach ($is_active as $key => $item) {
						?>
							<option value="<?=$key?>"><?=$item?></option>
						<?php
							}
						?>
						</select>
					</td>
					<td>
						<select name="ing_preservation" class="form-control form-filter input-sm">
							<option value="">Select...</option>
						<?php
							foreach ($is_active as $key => $item) {
						?>
							<option value="<?=$key?>"><?=$item?></option>
						<?php
							}
						?>
						</select>
					</td>
					<td>
						<select name="ing_pregantcaution" class="form-control form-filter input-sm">
							<option value="">Select...</option>
						<?php
							foreach ($is_active as $key => $item) {
						?>
							<option value="<?=$key?>"><?=$item?></option>
						<?php
							}
						?>
						</select>
					</td>
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