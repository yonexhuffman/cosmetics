<div class="main">
	<div class="container">
		<div class="row padding">
			<div class="col-sm-12 col-md-3 item-box text-center left-box" style="padding: 10px;">
				<form method="POST" action="<?=site_url('dashboard/updateuser')?>" enctype="multipart/form-data" class="form_update_user">
				<?php
					$image_url = base_url($avatar_image_path . 'default.png');
					if (!empty($cur_userdata['acc_image']) && file_exists($avatar_image_path . $cur_userdata['acc_image'])) {
						$image_url = base_url($avatar_image_path . $cur_userdata['acc_image']);
					}
				?>
					<img src="<?=$image_url?>" width="200" id="preview_image">
					<div class="panel-group accordion margin-top10" id="accordion_updateuser">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion_updateuser" href="#accordion_updateuser_collapse" aria-expanded="false">
								用户细节</a>
								</h4>
							</div>
							<div id="accordion_updateuser_collapse" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body" style="padding: 15px 0px;">
									<div class="form-group" style="margin-bottom: 0px;">
										<label class="col-sm-12 col-md-12 text-center">
											<span class="btn cosmetic-btn fileinput-button margin-top10">
											<i class="fa fa-file-picture-o"></i>
											<span>
											选择头像 </span>
											<input type="file" name="acc_image">
											</span>
										</label>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 col-md-12 text-left">用户名</label>
										<div class="col-md-12">
											<input type="text" name="user_nickname" class="form-control" placeholder="用户名" value="<?=$cur_userdata['user_nickname']?>" />
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 col-md-12 text-left">账号</label>
										<div class="col-md-12">
											<input type="text" name="user_id" class="form-control" placeholder="账号" value="<?=$cur_userdata['user_id']?>" />
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 col-md-12 text-left">电子邮件</label>
										<div class="col-md-12">
											<input type="text" name="user_email" class="form-control" placeholder="电子邮件" value="<?=$cur_userdata['user_email']?>" />
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 col-md-12 text-left">电话号码</label>
										<div class="col-md-12">
											<input type="text" name="user_phonenumber" class="form-control" placeholder="电话号码" value="<?=$cur_userdata['user_phonenumber']?>" />
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-center">
											<button class="btn cosmetic-btn"><i class="fa fa-save"></i> 保管</button>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion_updateuser" href="#accordion_updatepassword_collapse" aria-expanded="false">
								更改密码</a>
								</h4>
							</div>
							<div id="accordion_updatepassword_collapse" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
								<div class="panel-body" style="padding: 15px 0px;">
									<div class="form-group">
										<label class="col-sm-12 col-md-12 text-left">旧密码</label>
										<div class="col-md-12">
											<input type="password" name="prev_user_pass" class="form-control" placeholder="旧密码" />
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 col-md-12 text-left">新密码</label>
										<div class="col-md-12">
											<input type="password" name="user_password" class="form-control" placeholder="新密码" />
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-12 col-md-12 text-left">确认密码</label>
										<div class="col-md-12">
											<input type="password" name="new_user_password_confirm" class="form-control" placeholder="确认密码" />
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="form-group">
										<div class="col-md-12 text-center">
											<button type="button" class="btn cosmetic-btn update_userpassword"><i class="fa fa-save"></i> 更改密码</button>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-12 col-md-9 item-box text-center padding">
	            <ul class="nav nav-tabs">
	                <li class="active">
	                    <a href="#tab_1" data-toggle="tab">收藏</a>
	                </li>
	                <li class="">
	                    <a href="#tab_2" data-toggle="tab">评论</a>
	                </li>
	            </ul>
	            <div class="tab-content" style="padding: 15px 0px;">
	                <div class="tab-pane fade active in ingredient_panel" id="tab_1">
	                	<?php
	                		if (isset($fav_products['product_list']) && count($fav_products['product_list']) > 0) {
	                	?>
	                	<div class="row">
		                	<div class="col-md-12">
		                		<input type="hidden" id="current_page_fav" value="<?php echo ($fav_products['current_page']) ? $fav_products['current_page'] : '' ?>">
		                		<button class="btn default go_page_fav prev" pageindex="<?=$fav_products['prev_page']?>" <?php echo ($fav_products['prev_page'] < 0) ? 'disabled' : '' ?>><i class="fa fa-angle-left"></i></button>
		                		&nbsp;&nbsp;&nbsp;<span id="fav_paging_label"><?=$fav_products['current_page'] . ' / ' . $fav_products['total_page']?></span>&nbsp;&nbsp;&nbsp;
		                		<button class="btn default go_page_fav next" pageindex="<?=$fav_products['next_page']?>" <?php echo ($fav_products['next_page'] < 0) ? 'disabled' : '' ?>><i class="fa fa-angle-right"></i></button>
		                	</div>
	                	</div>
	                	<ul id="productlist">
	                	<?php
	                			foreach ($fav_products['product_list'] as $key => $record) {
	                	?>
	                		<li class="product_item">
		                        <div class="link pull-left">
		                    		<a href="<?=site_url('product/item?pro_id=' . $record['pro_id'])?>">
		                            	<p class="title"><?=$record['pro_title']?></p>
		                    		</a>
		                        </div>
		                        <div class="delete pull-right">
		                        	<button class="btn cosmetic-btn deletefav" pro-id="<?=$record['pro_id']?>">
		                        		<i class="fa fa-trash"></i>
		                        	</button>
		                        </div>
		                        <div class="clearfix"></div>
			                </li>
	                	<?php
	                			}
	                	?>
	                	</ul>
	                	<?php
	                		}
	                		else {
	                	?>
	                	<ul id="productlist">
	                		<li class="product_item">
	                			没有资料
	                		</li>
	                	</ul>
	                	<?php
	                		}
	                	?>
	                </div>
	                <div class="tab-pane fade user_blog_list " id="tab_2">
	                	<?php
	                		if (isset($blogs['blog_list']) && count($blogs['blog_list']) > 0) {
	                	?>
	                	<div class="row">
		                	<div class="col-md-12">
		                		<input type="hidden" id="current_page_blog" value="<?php echo ($blogs['current_page']) ? $blogs['current_page'] : '' ?>">
		                		<button class="btn default go_page_blog prev" pageindex="<?=$blogs['prev_page']?>" <?php echo ($blogs['prev_page'] < 0) ? 'disabled' : '' ?>><i class="fa fa-angle-left"></i></button>
		                		&nbsp;&nbsp;&nbsp;<span id="blog_paging_label"><?=$blogs['current_page'] . ' / ' . $blogs['total_page']?></span>&nbsp;&nbsp;&nbsp;
		                		<button class="btn default go_page_blog next" pageindex="<?=$blogs['next_page']?>" <?php echo ($blogs['next_page'] < 0) ? 'disabled' : '' ?>><i class="fa fa-angle-right"></i></button>
		                	</div>
	                	</div>
	                	<ul id="bloglist" >
	                	<?php
	                			foreach ($blogs['blog_list'] as $key => $record) {
	                	?>
	                		<li class="product_item" blog-id="<?=$record['b_id']?>">
	                			<div class="xxs-info-box line">
				                    <div class="xxs-info-title">
				                        <div class="xxs-info-title-main">
				                            <p class="p1"><?=$record['b_title']?></p>
				                            <div class="p2"><?=$record['b_tags']?></div>
				                        </div>
				                        <div class="clear"></div>
				                    </div>
				                    <div class="xxs-info-content"><?=$record['b_content']?></div>
				                	<button class="btn cosmetic-btn btn_readmore">查看全部</button>
				                	<button class="btn cosmetic-btn deleteblog">
				                		<i class="fa fa-trash"></i>
				                	</button>
				                </div>
			                </li>
	                	<?php
	                			}
	                	?>
	                	</ul>
	                	<?php
	                		}
	                		else {
	                	?>
	                	<ul id="productlist">
	                		<li class="product_item">
	                			没有资料
	                		</li>
	                	</ul>
	                	<?php
	                		}
	                	?>
	                </div>
	            </div>
				<div class="panel-group accordion margin-top10" id="accordion1">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_4" aria-expanded="false">
							意见反馈</a>
							</h4>
						</div>
						<div id="collapse_4" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
							<div class="panel-body">
							<form method="POST" action="<?=site_url('dashboard/sendopinion')?>" id="sendopinion_form">
								<textarea class="form-control" rows="10" name="content"></textarea>
								<p class="margin-top10">
									<button class="btn cosmetic-btn" type="button" id="sendopinion">
									发送 </button>
								</p>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>