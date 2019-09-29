<div class="row">
	<div class="col-md-12">
		<div class="form-wizard">
			<div class="form-body" id="scrapping_step">
				<ul class="nav nav-pills nav-justified steps">
					<li class="active">
						<a href="#tab_1" data-toggle="tab" class="step tab_1">
						<span class="number">
						1 </span>
						<span class="desc">
						<i class="fa fa-check"></i> 化妆品 </span>
						</a>
					</li>
					<li>
						<a href="#tab_2" data-toggle="tab" class="step tab_2">
						<span class="number">
						2 </span>
						<span class="desc">
						<i class="fa fa-check"></i> 成分 </span>
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<table class="table table-bordered" id="product_table">
							<colgroup>
								<col width="5%"></col>
								<col width="15%"></col>
								<col width="35%"></col>
								<col width="15%"></col>
								<col width="15%"></col>
								<col width="15%"></col>
							</colgroup>
							<thead>
								<tr role="row" class="heading">
									<th>序号</th>
									<th>类别</th>
									<th>百分</th>
									<th>记录日期时间</th>
									<th>结果</th>
									<th>刮</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$i = 1;
								foreach ($product_logs as $key => $item) {
							?>
								<tr cat-id="<?=$item['cat_new_id']?>">
									<td><?=$i?></td>
									<td><?=$item['cat_new_name']?></td>
									<td>
										<div id="product_progressbar_<?=$item['cat_new_id']?>" class="progress progress-striped" role="progressbar">
											<div class="progress-bar progress-bar-primary">
												<span class="percent_label">0%</span>
											</div>
										</div>
									</td>
									<td>
										<span class="log_datetime_<?=$item['cat_new_id']?>"><?=$item['log_datetime']?></span>
									</td>
									<td>
										<span class="label label-sm label-danger status_label_<?=$item['cat_new_id']?>"></span>
									</td>
									<td>
										<button class="btn btn-sm scrape_product"><i class="fa fa-download"></i> 刮</button>
									</td>
								</tr>
							<?php
									$i ++;
								}
							?>
							</tbody>
						</table>
					</div>					
					<div class="tab-pane " id="tab_2">
						<table class="table table-bordered" id="ingredient_table">
							<colgroup>
								<col width="5%"></col>
								<col width="15%"></col>
								<col width="35%"></col>
								<col width="15%"></col>
								<col width="15%"></col>
								<col width="15%"></col>
							</colgroup>
							<thead>
								<tr role="row" class="heading">
									<th>序号</th>
									<th>类别</th>
									<th>百分</th>
									<th>记录日期时间</th>
									<th>结果</th>
									<th>刮</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$i = 1;
								foreach ($ingredient_logs as $key => $item) {
							?>
								<tr cat-id="<?=$item['cat_new_id']?>">
									<td><?=$i?></td>
									<td><?=$item['cat_new_name']?></td>
									<td>
										<div id="ingredient_progressbar_<?=$item['cat_new_id']?>" class="progress progress-striped" role="progressbar">
											<div class="progress-bar progress-bar-primary">
												<span class="percent_label">0%</span>
											</div>
										</div>
									</td>
									<td>
										<span class="log_datetime_<?=$item['cat_new_id']?>"><?=$item['log_datetime']?></span>
									</td>
									<td>
										<span class="label label-sm label-danger status_label_<?=$item['cat_new_id']?>"></span>
									</td>
									<td>
										<button class="btn btn-sm scrape_category_ingredient"><i class="fa fa-download"></i> 刮</button>
									</td>
								</tr>
							<?php
									$i ++;
								}
							?>
							</tbody>
						</table>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>