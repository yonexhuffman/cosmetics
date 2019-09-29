<script type="text/javascript">
	var handleSubmit = function() {
		$('.new_blogtags_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                tag_name: {
                    required: true
                },
            },

            messages: {
                tag_name: {
                    required: "这是必填栏。"
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.new_blogtags_form')).show();
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

        $('.new_blogtags_form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.new_blogtags_form').validate().form()) {
                    $('.new_blogtags_form').submit();
                }
                return false;
            }
        });
	}

    handleSubmit();

    $(document).on('click' , '.btn-delete' , function(){
    	var tag_id = $(this).parents('tr').attr('tag-id');
    	if (confirm('你真的想删除它吗？')) {
    		$.ajax({
    			url : site_url + 'admin/blogtags/delete' , 
    			type: 'POST' , 
    			data: {
    				tag_id : tag_id , 
    			} , 
    			dataType: 'JSON' , 
    			success: function(response){
    				if (response.success) {
    					location.href = site_url + 'admin/blogtags';
    				}
    				else {
                        toastr['error']('操作失败.');
    				}
    			}
    		})
    	}
    })

    $(document).on('click' , '.btn-update' , function(){
    	var tag_id = $(this).parents('tr').attr('tag-id');
    	var tag_name = $(this).parents('tr').find('td').eq(1).html();
    	$('.new_blogtags_form input[name=tag_id]').val(tag_id);
    	$('.new_blogtags_form input[name=tag_name]').val(tag_name);
    	
    	$('.portlet .portlet-title .tools a').removeClass('expand').addClass('collapse');
    	$('.portlet .portlet-body').show();
    })
</script>