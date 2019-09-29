<script src="<?php echo base_url('assets/global/scripts/metronic.js');?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/admin/layout/scripts/demo.js');?>" type="text/javascript"></script>

<script>
jQuery(document).ready(function() {     
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init();
	// init background slide images
	$.backstretch([
		    "<?php echo base_url('uploads/bg/1.jpg');?>",
		    "<?php echo base_url('uploads/bg/2.jpg');?>",
		    "<?php echo base_url('uploads/bg/3.jpg');?>",
		    "<?php echo base_url('uploads/bg/4.jpg');?>"
		    ], {
		      fade: 1000,
		      duration: 8000
		}
	);

	var handleLogin = function() {
		$('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                user_id: {
                    required: true
                },
                user_password: {
                    required: true
                }
            },

            messages: {
                user_id: {
                    required: "请输入用户名."
                },
                user_password: {
                    required: "请输入密码."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
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
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit();
                }
                return false;
            }
        });
	}

    handleLogin();

    var handleForgetPassword = function () {
		$('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },

            messages: {
                email: {
                    required: "Email is required."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   

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
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function () {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

	}

	handleForgetPassword();
	
	var handleRegister = function () {

         $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {	                
	                user_nickname: {
	                    required: true
	                },
	                user_email: {
	                    required: true,
	                    email: true
	                },
	                user_phonenumber: {
	                    required: true
	                },
	                user_id: {
	                    required: true
	                },
	                user_password: {
	                    required: true
	                },
	                rpassword: {
	                    equalTo: "#register_password"
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes              
	                user_nickname: {
	                    required: "这是必填栏。"
	                },
	                user_email: {
	                    required: "这是必填栏。",
	                    email: "电子邮件格式错误。"
	                },
	                user_phonenumber: {
	                    required: "这是必填栏。"
	                },
	                user_id: {
	                    required: "这是必填栏。"
	                },
	                user_password: {
	                    required: "这是必填栏。"
	                },
	                rpassword: {
	                    equalTo: "验证密码不正确。"
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

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
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	            	if (!ischeckuserid) {
	                	form.submit();
	            	}
	            	else {
	            		$('.register-form input[name=user_id]').parents('.form-group').addClass('has-error').find('.help-block').html('This userid already exists !').show();
	            	}
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}

	handleRegister();

	var ischeckuserid = false;
	$(document).on('keyup' , '.register-form input[name=user_id]' , function(){
		var user_id = $(this).val();
		var formgroup_element = $(this).parents('.form-group');
		if (user_id != '') {
			$.ajax({
				url : '<?=site_url('login/checkuserid')?>' , 
				type: 'POST' , 
				dataType: 'JSON' , 
				data: {
					user_id : user_id
				} , 
				success: function(response) {
					if (response.success) {
						ischeckuserid = true;
						formgroup_element.addClass('has-error');
						if (formgroup_element.find('.help-block').length == 0) {
							formgroup_element.append('<span class="help-block">This userid already exists !</span>');
						}
						else {
							formgroup_element.find('.help-block').show();
							formgroup_element.find('.help-block').html('This userid already exists !');
						}
					}
					else {
						ischeckuserid = false;
						formgroup_element.removeClass('has-error');
						formgroup_element.find('.help-block').hide();
					}
				}
			})
		}
	})
    	
});
</script>