<script type="text/javascript">
    jQuery.loadScript = function (url, callback) {
        jQuery.ajax({
            url: url ,
            dataType: 'script',
            success: callback,
            async: true
        });
    }

    $(window).scroll(function(){
        if (($(window).scrollTop() == $(document).height() - $(window).height())) {            
            var blog_last_id = $('#blog_last_id').val();
            if (parseInt(blog_last_id) >= 0) {
                var ing_id = $('#ing_id').val();
                $.ajax({
                    url : site_url + 'admin/blogingredient/loadMoreData' , 
                    type: 'POST' , 
                    data: {
                        blog_last_id : blog_last_id , 
                        ing_id : ing_id , 
                    } , 
                    dataType: 'json' , 
                    success: function(response){
                        if (typeof someObject == 'undefined') $.loadScript(base_url + 'assets/global/plugins/rateit/src/jquery.rateit.js', function(){
                            //Stuff to do after someScript has loaded
                        });
                        $('#blog_last_id').val(response.blog_last_id);
                        $('#blog_list_view').append(response.html);
                        if (parseInt(response.blog_last_id) < 0) {
                            $('#loadMoreData_icon').hide();
                        }
                    }
                })
            }
        }
    })

    $(document).on('click' , '.btn_delete' , function(){
        if (confirm('你真的想删除它吗？')) {
            var b_id = $(this).parents('.blog-content').attr('blog-id');
            if ($(this).parents('.blog-comment').length > 0) {
                var cur_blog_dom = $(this).parents('.blog-comment');
            }
            else 
                var cur_blog_dom = $(this).parents('.xxs-info-box');
            $.ajax({
                url : site_url + 'admin/blogingredient/delete' , 
                type: 'POST' , 
                data: {
                    b_id : b_id , 
                } , 
                dataType: 'json' , 
                success: function(response){
                    if (response.success) {
                        toastr['success']('操作成功.');
                        cur_blog_dom.remove();
                    }
                    else {
                        toastr['error']('操作失败.');
                    }
                }
            })
        }
    })

    $(document).on('click' , '.btn_update' , function(){
        $('.xxs-info-box .btn_cancel').trigger('click');
        $(this).removeClass('btn_update').addClass('btn_save').html('保存');
        $(this).parents('.blog-content').find('.btn_delete').removeClass('btn_delete').addClass('btn_cancel').html('取消');

        var parent_dom = $(this).parents('.blog-content');
        var title = parent_dom.find('.xxs-info-title-main .p1').html(); 
        var content = parent_dom.find('.xxs-info-content').html().replace(/<br *\/?>/gi, '\n'); 
        
        // parent_dom.find('.xxs-info-title-main .p1').html('<input type="text" class="form-control" value="' + title + '">');
        parent_dom.find('.xxs-info-content').html('<textarea rows="5" class="form-control">' + content + '</textarea>');
    })

    $(document).on('click' , '.btn_cancel' , function(){
        $(this).removeClass('btn_cancel').addClass('btn_delete').html('删除');
        $(this).parents('.blog-content').find('.btn_save').removeClass('btn_save').addClass('btn_update').html('更新');
        var parent_dom = $(this).parents('.blog-content');
        var title = parent_dom.find('.xxs-info-title-main .p1 input').val(); 
        var content = parent_dom.find('.xxs-info-content textarea').val().replace(/(?:\r\n|\r|\n)/g, '<br>'); 
        // parent_dom.find('.xxs-info-title-main .p1').html(title);
        parent_dom.find('.xxs-info-content').html(content);
    })

    $(document).on('click' , '.btn_save' , function(){
        if (confirm('您想继续操作吗？')) {
            var b_id = $(this).parents('.blog-content').attr('blog-id');
            var cur_blog_dom = $(this).parents('.blog-content');
            // var b_title = cur_blog_dom.find('.xxs-info-title-main .p1 input').val();
            var b_content = cur_blog_dom.find('.xxs-info-content textarea').val(); 
            var b_user_rate = cur_blog_dom.find('.b_user_rate').val();
            
            $.ajax({
                url : site_url + 'admin/blogingredient/update' , 
                type: 'POST' , 
                data: {
                    b_id : b_id , 
                    b_content : b_content , 
                    b_user_rate : b_user_rate
                } , 
                dataType: 'json' , 
                success: function(response){
                    if (response.success) {
                        $('.xxs-info-box .btn_cancel').trigger('click');
                        toastr['success']('操作成功.');
                    }
                    else {
                        toastr['error']('操作失败.');
                    }
                }
            })
        }
    })
</script>