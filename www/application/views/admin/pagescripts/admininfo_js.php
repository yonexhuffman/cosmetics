<script>
    $(document).on('click' , '#btn_update' , function(){
        var prev_user_pass = $('#update_form #prev_user_pass').val();
        var cur_pass = $('#update_form #cur_password').val();
    	if ($('#update_form #prev_user_pass').val() == ''
            || $('#update_form #user_pass').val() == ''
            || $('#update_form #new_user_pass_confirm').val() == ''
        ) {
            alert('请输入正确的资料.');
    		return;
    	}
        
        $.ajax({
            url : site_url + 'admin/admininfo/confirmprevpassword' , 
            type: 'POST' , 
            dataType: 'JSON' , 
            data: {
                prev_user_pass : prev_user_pass , 
                cur_pass : cur_pass , 
            } , 
            success: function(response) {
                if(response.success) {
                    if($('#update_form #user_pass').val() != $('#update_form #new_user_pass_confirm').val()){
                        toastr['error']('确认密码不正确.');
                        return;
                    }
                    else {
                        loadingstart('#body_container');
                        $('#update_form').submit();
                    }
                }
                else {
                    toastr['error']('旧密码不正确.');
                }
            }
        });
    });
</script>