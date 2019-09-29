<div class="row">
	<div class="col-md-12">
		<?php
			if ($is_reset_rankingnumber) {
		?>
		<!-- <div class="row">
			<div class="col-md-12">
				<div id="bar" class="progress progress-striped" role="progressbar">
					<div class="progress-bar progress-bar-primary">
						<span class="percent_label">0%</span>
					</div>
				</div>	
			</div>
		</div> -->
		<?php
			}
		?>
		<!-- <div class="row ">
			<div class="col-md-12 text-right">
				<a href="<?=site_url('/admin/company/update')?>" class="btn btn-success"><i class="fa fa-plus"></i> 添加</a>
				<button class="btn btn-success" id="reset_rankingnumber">品牌人气排名更新</button>
			</div>
		</div> -->
		<table class="table table-striped table-bordered table-hover" id="data_ajaxtable">
			<thead>
				<tr role="row" class="heading">
					<th>序号</th>
					<th>图片</th>
					<th>品牌名称</th>
					<th>英文名</th>
					<th>国家</th>
					<th>人气排名</th>
					<th></th>
				</tr>
				<tr role="row" class="filter">
					<td></td>
					<td></td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="com_name">
					</td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="com_alias">
					</td>
					<td>
						<input type="text" class="form-control form-filter input-sm" name="com_country">
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