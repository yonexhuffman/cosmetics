 <script type="text/javascript">
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

    $(document).on('click' , '#sendopinion' , function(){
    	if ($('#sendopinion_form textarea').val() == '') {
    		return;
    	}
    	$('#sendopinion_form').submit();
    })

    function go_pagefav(page_index){
    	$.ajax({
    		url : site_url + 'dashboard/get_favoriteproduct' , 
    		type: 'POST' , 
    		data: {
    			page_index : page_index , 
    		} , 
    		dataType: 'json' , 
    		success: function(response){
    			if (response) {
    				$('#fav_paging_label').html(response.current_page + ' / ' + response.total_page);
    				$('#current_page_fav').val(response.current_page);
    				$('.go_page_fav.prev').attr('pageindex' , response.prev_page);
    				$('.go_page_fav.next').attr('pageindex' , response.next_page);
    				if (response.prev_page < 0) {
    					$('.go_page_fav.prev').attr('disabled' , true);	
    				}
    				else {
    					$('.go_page_fav.prev').attr('disabled' , false);	
    				}
    				if (response.next_page < 0) {
    					$('.go_page_fav.next').attr('disabled' , true);	
    				}
    				else {
    					$('.go_page_fav.next').attr('disabled' , false);	
    				}
    				var content = '';
    				if (response.product_list.length == 0) {
    					content = '<li class="product_item">没有资料</li>';
    				}
    				else {
	    				for(var i = 0 ; i < response.product_list.length ; i ++){
	    					content += '<li class="product_item"><div class="link pull-left"><a href="' + 	site_url + 'product/item?pro_id=' + response.product_list[i].pro_id + '"><p class="title">' + response.product_list[i].pro_title + '</p></a></div><div class="delete pull-right"><button class="btn cosmetic-btn deletefav" pro-id="' + response.product_list[i].pro_id + '"><i class="fa fa-trash"></i></button></div><div class="clearfix"></div></li>'
	    				}	
    				}
    				$('ul#productlist').html(content);
    			}
    		}
    	})
    }

    $(document).on('click' , '.deletefav' , function(){
        if (confirm('确定删除吗？')) {
    		var pro_id = $(this).attr('pro-id');
            $.ajax({
                url : site_url + 'dashboard/deletefavoriteproduct' , 
                type: 'POST' , 
                data: {
                    pro_id : pro_id , 
                } , 
                dataType: 'json' , 
                success: function(response){
                    if (response.success) {
                        // toastr['success']('操作成功.');
                        go_pagefav($('#current_page_fav').val());
                    }
                    else {
                        toastr['error']('操作失败.');
                    }
                }
            })
        }
    })

    $(document).on('click' , '.go_page_fav' , function(){
    	var page_index = $(this).attr('pageindex');
    	go_pagefav(page_index);
    })

    function go_page_blog(page_index){
        $.ajax({
            url : site_url + 'dashboard/get_blogs' , 
            type: 'POST' , 
            data: {
                page_index : page_index , 
            } , 
            dataType: 'json' , 
            success: function(response){
                if (response) {
                    $('#blog_paging_label').html(response.current_page + ' / ' + response.total_page);
                    $('#current_page_blog').val(response.current_page);
                    $('.go_page_blog.prev').attr('pageindex' , response.prev_page);
                    $('.go_page_blog.next').attr('pageindex' , response.next_page);
                    if (response.prev_page < 0) {
                        $('.go_page_blog.prev').attr('disabled' , true); 
                    }
                    else {
                        $('.go_page_blog.prev').attr('disabled' , false);    
                    }
                    if (response.next_page < 0) {
                        $('.go_page_blog.next').attr('disabled' , true); 
                    }
                    else {
                        $('.go_page_blog.next').attr('disabled' , false);    
                    }
                    var content = '';
                    if (response.blog_list.length == 0) {
                        content = '<li class="product_item">没有资料</li>';
                    }
                    else {
                        for(var i = 0 ; i < response.blog_list.length ; i ++){
                            content += '<li class="product_item" blog-id="' + response.blog_list[i].b_id + '"><div class="xxs-info-box line"><div class="xxs-info-title"><div class="xxs-info-title-main"><p class="p1">' + response.blog_list[i].b_title + '</p><div class="p2">' + response.blog_list[i].b_tags + '</div></div><div class="clear"></div></div><div class="xxs-info-content">' + response.blog_list[i].b_content + '</div><button class="btn cosmetic-btn btn_readmore">查看全部</button><button class="btn cosmetic-btn deleteblog"><i class="fa fa-trash"></i></button></div></li>';
                        }   
                    }
                    $('ul#bloglist').html(content);
                }
            }
        })
    }

    $(document).on('click' , '.go_page_blog' , function(){
        var page_index = $(this).attr('pageindex');
        go_page_blog(page_index);
    })

    var defaultHeight = 60;

    $(document).on('click' , '.btn_readmore' , function(){
        var content_dom = $(this).parent().find('.xxs-info-content').first();
        if ($(this).hasClass('more')) {
            var newHeight = defaultHeight;
            $(this).removeClass('more');
            $(this).html('查看全部');
        }
        else {
            var newHeight = content_dom[0].scrollHeight;
            $(this).addClass('more');   
            $(this).html('返回');
        }
        content_dom.animate({
            "height": newHeight
        }, 500);
    })

    $(document).on('click' , '.deleteblog' , function(){
        if (confirm('确定删除吗？')) {
            var b_id = $(this).parents('li').attr('blog-id');
            $.ajax({
                url : site_url + 'dashboard/deleteblog' , 
                type: 'POST' , 
                data: {
                    b_id : b_id , 
                } , 
                dataType: 'json' , 
                success: function(response){
                    if (response.success) {
                        // toastr['success']('操作成功.');
                        go_page_blog($('#current_page_blog').val());
                    }
                    else {
                        toastr['error']('操作失败.');
                    }
                }
            })
        }
    })

    $(document).on('click' , '.update_userpassword' , function(){
        var prev_user_pass = $('input[name=prev_user_pass]').val();
        var user_password = $('input[name=user_password]').val();
        var new_user_password_confirm = $('input[name=new_user_password_confirm]').val();
        if (prev_user_pass == '' || user_password == '' || new_user_password_confirm == '') {
            alert('请输入正确的资料.');
            return;
        }
        
        $.ajax({
            url : site_url + '/dashboard/update_userpassword' , 
            type: 'POST' , 
            dataType: 'JSON' , 
            data: {
                prev_user_pass : prev_user_pass , 
                user_password : user_password , 
                new_user_password_confirm : new_user_password_confirm , 
            } , 
            success: function(response) {
                if(response.success) {
                    toastr['success'](response.message);
                }
                else {
                    toastr['error'](response.message);
                }
            }
        });
    })

    var handleSubmit = function() {
        $('.form_update_user').validate({
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
                user_email: {
                    required: true , 
                    email: true
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
                user_email: {
                    required: "这是必填栏。" , 
                    email: "电子邮件格式错误。"
                },
                user_phonenumber: {
                    required: "这是必填栏。"
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.form_update_user')).show();
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

<?php
    if (isset($post_result_updateuser_alarm_message)){
        if ($post_result_updateuser_alarm_message['success']) {
?>
            toastr['success']('<?=$post_result_updateuser_alarm_message['message']?>');
<?php
        }
        else {
?>
            toastr['error']('<?=$post_result_updateuser_alarm_message['message']?>');
<?php        
        }
    }
?>
</script>