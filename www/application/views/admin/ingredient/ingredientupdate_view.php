<div class="row" style="margin: 0;">
	<div class="col-md-12 form">
	<form class="form-horizontal new_ingredient_form" role="form" method="POST" action="<?=site_url('admin/ingredient/insert')?>" enctype="multipart/form-data">
		<input type="hidden" name="ing_id" value="<?php echo isset($ing_id) ? $ing_id : -1;?>">
		<div class="form-body">
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 成分名称<span class="required">*</span> </label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="成分名称" name="ing_name" value="<?php echo isset($ingredient_data['ing_name']) ? $ingredient_data['ing_name'] : '';?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 英文名</label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="英文名" name="ing_alias" value="<?php echo isset($ingredient_data['ing_alias']) ? $ingredient_data['ing_alias'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 成分别名</label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="成分别名" name="ing_remark" value="<?php echo isset($ingredient_data['ing_remark']) ? $ingredient_data['ing_remark'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> CAS号<span class="required">*</span></label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="CAS号" name="ing_csano" value="<?php echo isset($ingredient_data['ing_csano']) ? $ingredient_data['ing_csano'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label"> 使用目的<span class="required">*</span></label>
						<div class="col-sm-7 col-md-7">
							<input type="text" class="form-control" placeholder="使用目的" name="ing_usage_purpose" value="<?php echo isset($ingredient_data['ing_usage_purpose']) ? $ingredient_data['ing_usage_purpose'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4 col-md-4 control-label">成分简介</label>
						<div class="col-sm-7 col-md-7">
							<textarea class="form-control" rows="7" name="ing_overview"><?php echo isset($ingredient_data['ing_overview']) ? $ingredient_data['ing_overview'] : '';?></textarea>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">安全风险</label>
						<div class="col-sm-7 col-md-7">
						<?php
							$min_security_risk = '';
							$max_security_risk = '';
							if (isset($ingredient_data['ing_security_risk'])) {
								$buffer = explode('-', $ingredient_data['ing_security_risk']);
								$min_security_risk = isset($buffer[0]) ? intval($buffer[0]) : '';
								$max_security_risk = isset($buffer[1]) ? intval($buffer[1]) : '';
							}
						?>
							<input type="text" class="form-control" name="ing_security_risk[]" value="<?=$min_security_risk?>" style="width: 40%;display: inline-block;" >
							-
							<input type="text" class="form-control" name="ing_security_risk[]" value="<?=$max_security_risk?>" style="width: 40%;display: inline-block;">
						</div>
					</div>
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">活性成分</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_active']) && $ingredient_data['ing_active'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_active_<?=$key?>" <?=$checked?> name="ing_active" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_active_<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">致痘风险</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_acne_risk']) && $ingredient_data['ing_acne_risk'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_acne_risk<?=$key?>" <?=$checked?> name="ing_acne_risk" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_acne_risk<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">香精</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_flavor']) && $ingredient_data['ing_flavor'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_flavor<?=$key?>" <?=$checked?> name="ing_flavor" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_flavor<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">防腐剂</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_preservation']) && $ingredient_data['ing_preservation'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_preservation<?=$key?>" <?=$checked?> name="ing_preservation" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_preservation<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">孕妇慎用</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_pregantcaution']) && $ingredient_data['ing_pregantcaution'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_pregantcaution<?=$key?>" <?=$checked?> name="ing_pregantcaution" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_pregantcaution<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">清洁</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_cleansing']) && $ingredient_data['ing_cleansing'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_cleansing<?=$key?>" <?=$checked?> name="ing_cleansing" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_cleansing<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">氨基酸表活</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_aminoacid']) && $ingredient_data['ing_aminoacid'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_aminoacid<?=$key?>" <?=$checked?> name="ing_aminoacid" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_aminoacid<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
					<div class="form-group col-md-6">
						<label class="col-sm-4 col-md-4 control-label">sls/sles</label>
						<div class="col-sm-7 col-md-7">
							<div class="md-radio-inline">
							<?php
								foreach ($is_active as $key => $item) {
									$checked = '';
									if (isset($ingredient_data['ing_sls_sles']) && $ingredient_data['ing_sls_sles'] == $key) {
										$checked = 'checked';
									}
									else if ($key == 0) {
										$checked = 'checked';
									}
							?>
								<div class="md-radio">
									<input type="radio" id="ing_sls_sles<?=$key?>" <?=$checked?> name="ing_sls_sles" class="md-radiobtn" value="<?=$key?>">
									<label for="ing_sls_sles<?=$key?>">
									<span></span>
									<span class="check"></span>
									<span class="box"></span>
									<?=$item?> </label>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> 保存</button>
					<a href="<?=site_url('/admin/ingredient/')?>" class="btn btn-default"><i class="fa fa-mail-reply"></i> 背部</a>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>