<div class="row" style="max-width: 800px;width: 800px;">
	<div class="col-md-12 form">
	<form class="form-horizontal new_account_form" role="form" method="POST" action="<?=site_url('admin/account/insert')?>" enctype="multipart/form-data">
		<input type="hidden" name="acc_id" value="<?php echo isset($acc_id) ? $acc_id : -1;?>">
		<div class="form-body">
			<div class="row" style="margin: 0px;">
				<div class="col-md-12">
					<div class="form-group" style="margin-top: 20px;">
						<label class="col-sm-3 col-md-3 control-label"> 用户名 </label>
						<div class="col-sm-8 col-md-8">
							<input type="text" name="user_nickname" class="form-control" value="<?php echo isset($account_data['user_nickname']) ? $account_data['user_nickname'] : '';?>" placeholder="用户名" >
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 用户权利</label>
						<div class="col-sm-8 col-md-5">
							<select class="form-control" name="user_role">
								<option></option>
							<?php
								foreach ($user_role as $key => $role) {
									$selected = '';
									if (isset($account_data['user_role']) && $key == $account_data['user_role']) {
										$selected = 'selected';
									}
							?>
								<option <?=$selected?> value="<?=$key?>"><?=$role?></option>
							<?php
								}
							?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 账号 </label>
						<div class="col-sm-8 col-md-8">
							<input type="text" name="user_id" class="form-control" value="<?php echo isset($account_data['user_id']) ? $account_data['user_id'] : '';?>" placeholder="账号">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 电子邮件 </label>
						<div class="col-sm-8 col-md-8">
							<input type="text" name="user_email" class="form-control" value="<?php echo isset($account_data['user_email']) ? $account_data['user_email'] : '';?>" placeholder="电子邮件">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 电话号码 </label>
						<div class="col-sm-8 col-md-8">
							<input type="text" name="user_phonenumber" class="form-control" value="<?php echo isset($account_data['user_phonenumber']) ? $account_data['user_phonenumber'] : '';?>" placeholder="电话号码">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 授权状态 </label>
						<div class="col-sm-8 col-md-8" style="padding-top: 10px;">
							<input type="checkbox" name="is_valid" <?php echo (isset($account_data['is_valid']) && $account_data['is_valid'] == 1) ? 'checked' : '';?> value="1" >
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 col-md-3 control-label"> 照片 </label>
						<div class="col-sm-8 col-md-8">
						<?php
							$image_url = base_url($avatar_image_path . 'default.png');
							if (!empty($account_data['acc_image']) && file_exists($avatar_image_path . $account_data['acc_image'])) {
								$image_url = base_url($avatar_image_path . $account_data['acc_image']);
						?>
							<img src="<?=$image_url?>" style="width: 60%;" id="preview_image">
						<?php
							}
							else {
						?>
							<img src="" style="width: 60%;display: none;" id="preview_image">
						<?php
							}
						?>
							<span class="btn green fileinput-button margin-top10">
							<i class="fa fa-file-picture-o"></i>
							<span>
							选择头像 </span>
							<input type="file" name="acc_image">
							</span>
							<input type="hidden" name="prev_acc_image" value="<?php echo isset($account_data['acc_image']) ? $account_data['acc_image'] : '';?>">
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> 保管</button>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</form>
	</div>
</div>

<script type="text/javascript">
    var handleSubmit = function() {
        $('.new_account_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                user_nickname: {
                    required: true
                },
                user_id: {
                    required: true
                },
                user_role: {
                    required: true
                },
                user_email: {
                    required: true
                },
                user_phonenumber: {
                    required: true
                },
            },

            messages: {
                user_nickname: {
                    required: "这是必填栏。"
                },
                user_id: {
                    required: "这是必填栏。"
                },
                user_role: {
                    required: "这是必填栏。"
                },
                user_email: {
                    required: "这是必填栏。"
                },
                user_phonenumber: {
                    required: "这是必填栏。"
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.new_account_form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.form-control'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    handleSubmit();	
    
    $(document).on('change' , 'input[name=acc_image]' , function(){
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview_image').show();
                $('#preview_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    })
</script>