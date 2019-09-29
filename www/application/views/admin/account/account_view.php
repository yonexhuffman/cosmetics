<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12 text-right">
				<a href="<?=site_url('admin/account/update')?>" class="btn btn-primary fancybox fancybox.ajax">
					<i class="fa fa-plus"></i> 添加
				</a>
			</div>
		</div>
		<table class="table table-striped table-bordered table-hover" id="data_ajaxtable">
			<colgroup>
				<col width="7%"></col>
				<col width="10%"></col>
				<col width="15%"></col>
				<col width="12%"></col>
				<col width="12%"></col>
				<col width="12%"></col>
				<col width="12%"></col>
				<col width="10%"></col>
				<col width="10%"></col>
			</colgroup>
			<thead>
				<tr role="row" class="heading">
					<th>序号</th>
					<th>照片</th>
					<th>用户名</th>
					<th>用户权利</th>
					<th>账号</th>
					<th>电子邮件</th>
					<th>电话号码</th>
					<th>授权状态</th>
					<th></th>
				</tr>
				<tr role="row" class="filter">
					<td></td>
					<td></td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="user_nickname">
					</td>
					<td>
						<select class="form-control form-filter input-sm" name="user_role">
							<option></option>
						<?php foreach ($user_role as $key => $role): ?>
							<option value="<?=$key?>"><?=$role?></option>
						<?php endforeach ?>
						</select>
					</td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="user_id">
					</td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="user_email">
					</td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="user_phonenumber">
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
			<tbody></tbody>
		</table>
	</div>	
</div>