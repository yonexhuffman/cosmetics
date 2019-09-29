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
						<i class="fa fa-check"></i> 进口化妆品 </span>
						</a>
					</li>
					<li>
						<a href="#tab_2" data-toggle="tab" class="step tab_2">
						<span class="number">
						2 </span>
						<span class="desc">
						<i class="fa fa-check"></i> 国内化妆品 </span>
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<div class="row">
							<div class="col-md-12 text-left">
								<button class="btn btn-success" id="scrapy_importedproduct">产品列表 刮 <i class="m-icon-swapright m-icon-white"></i></button>
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12 text-left">
								<div id="progressbar_importedproduct" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-primary">
										<span class="percent_label">0%</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-left">
								<button class="btn btn-success" id="scrapy_importedproduct_detail">产品明细 刮 <i class="m-icon-swapright m-icon-white"></i></button>
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12 text-left">
								<div id="progressbar_importedproduct_detail" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-primary">
										<span class="percent_label">0%</span>
									</div>
								</div>
							</div>
						</div>
					</div>					
					<div class="tab-pane " id="tab_2">
						<div class="row">
							<div class="col-md-3 text-left">
								<button class="btn btn-success" id="scrapy_domesticproduct">产品列表 刮 <i class="m-icon-swapright m-icon-white"></i></button>
							</div>
							<div class="col-md-2">
								<input type="text" class="form-control display-hide" value="" id="startpagenum">
							</div>
							<div class="col-md-2">
								<input type="text" class="form-control display-hide" value="" id="endpagenum">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12 text-left">
								<div id="progressbar_domesticproduct" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-primary">
										<span class="percent_label">0%</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-left">
								<button class="btn btn-success" id="scrapy_domesticproduct_detail">产品明细 刮 <i class="m-icon-swapright m-icon-white"></i></button>
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12 text-left">
								<div id="progressbar_domesticproduct_detail" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-primary">
										<span class="percent_label">0%</span>
									</div>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>