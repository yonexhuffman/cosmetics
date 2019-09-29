<script type="text/javascript">
	var handleSubmit = function() {
		$('.new_shoppingcategory_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                shoppingcat_name: {
                    required: true
                },
                // shoppingcat_img: {
                //     required: true
                // },
                disp_order_num: {
                    required: true , 
                    number: true , 
                    min: 0 , 
                }
            },

            messages: {
                shoppingcat_name: {
                    required: "这是必填栏。"
                },
                shoppingcat_img: {
                    required: "这是必填栏。"
                },
                disp_order_num: {
                    required: "这是必填栏。" , 
                    number: "输入值必须是数字。" , 
                    min: "最小值大于0。" , 
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.new_shoppingcategory_form')).show();
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

        $('.new_shoppingcategory_form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.new_shoppingcategory_form').validate().form()) {
                    $('.new_shoppingcategory_form').submit();
                }
                return false;
            }
        });
	}

    handleSubmit();

    $(document).on('click' , '.btn-delete' , function(){
    	var shop_cat_id = $(this).parents('tr').attr('shop-cat-id');
    	var shoppingcat_img = $(this).parents('tr').attr('image-name');
    	if (confirm('确定删除它吗？')) {
    		$.ajax({
    			url : site_url + 'admin/shoppingcategory/delete' , 
    			type: 'POST' , 
    			data: {
    				shop_cat_id : shop_cat_id , 
    				shoppingcat_img : shoppingcat_img
    			} , 
    			dataType: 'JSON' , 
    			success: function(response){
    				if (response.success) {
    					location.href = site_url + 'admin/shoppingcategory';
    				}
    				else {
                        toastr['error']('操作失败.');
    				}
    			}
    		})
    	}
    })

    $(document).on('click' , '.btn-update' , function(){
    	var shop_cat_id = $(this).parents('tr').attr('shop-cat-id');
    	var shop_cat_name = $(this).parents('tr').find('td').eq(2).html();
    	var disp_order_num = $(this).parents('tr').find('td').eq(3).html();
    	$('.new_shoppingcategory_form input[name=shop_cat_id]').val(shop_cat_id);
    	$('.new_shoppingcategory_form input[name=shoppingcat_name]').val(shop_cat_name);
    	$('.new_shoppingcategory_form input[name=disp_order_num]').val(disp_order_num);
    	
    	$('.portlet .portlet-title .tools a').removeClass('expand').addClass('collapse');
    	$('.portlet .portlet-body').show();
    })
</script>