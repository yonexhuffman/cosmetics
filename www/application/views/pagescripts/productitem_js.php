 <script type="text/javascript">    

    function loadBlogMoreData(){       
        var blog_last_id = $('#blog_last_id').val();
        if (parseInt(blog_last_id) >= 0) {
            var pro_id = $('#pro_id').val();
            $.ajax({
                url : site_url + 'product/loadBlogMoreData' , 
                type: 'POST' , 
                data: {
                    blog_last_id : blog_last_id , 
                    pro_id : pro_id , 
                } , 
                dataType: 'json' , 
                success: function(response){
                    if (typeof someObject == 'undefined') $.loadScript(base_url + 'assets/global/plugins/rateit/src/jquery.rateit.js', function(){
                        //Stuff to do after someScript has loaded
                    });
                    $('#blog_last_id').val(response.blog_last_id);
                    $('#blog_list_view').append(response.html);
                    if (parseInt(response.blog_last_id) < 0) {
                        $('#loadMoreData_btn').hide();
                    }
                }
            })
        }
    }
    
    // $('.fancybox').fancybox({
    //     minWidth : 800 , 
    //     width : 800
    // });

    var ing_first_showcount = '<?=LOADDATAPERPAGE?>';

    $(document).on('click' , '.ing_expand' , function(){
        $('table.ing_table tbody tr.display-hide').removeClass('display-hide');
        $(this).removeClass('ing_expand').addClass('ing_collapse').html('收起成分');
    })

    $(document).on('click' , '.ing_collapse' , function(){
        $(this).removeClass('ing_collapse').addClass('ing_expand').html('查看全部成分');
        $('table.ing_table tbody tr').each(function(index){
            if (index >= ing_first_showcount) {
                $(this).addClass('display-hide');
            }
        });
    })

    $(document).on('click' , '.safty_btn_wrapper button' , function(){
        var table_class_name = $(this).attr('name');
        $('#tab_2 table').each(function(){
            if (!$(this).hasClass('display-hide')) {
                $(this).addClass('display-hide');
            }
        })
        $('#tab_2 table.' + table_class_name).removeClass('display-hide');
    })

    $(document).on('click' , '.efficacy_btn_wrapper button' , function(){
        var table_class_name = $(this).attr('name');
        $('#tab_3 table').each(function(){
            if (!$(this).hasClass('display-hide')) {
                $(this).addClass('display-hide');
            }
        })
        $('#tab_3 table.' + table_class_name).removeClass('display-hide');
    })

    $(document).on('click' , '#send_comment' , function(){
        var this_dom = $(this);
        if (this_dom.parents('#form_send_comment').find('textarea[name=b_content]').val() == '') {
            alert('请输入题目!');
            this_dom.parents('#form_send_comment').find('textarea[name=b_content]').focus();
            return;
        }
        else
            this_dom.parents('#form_send_comment').submit();
    })

    $(document).on('click' , '#blog_btn' , function(){
        $('.commment-box input[name=b_id]').val('');
        $('.commment-box').show();
        var header_height = parseFloat($("body > .header").height());
        var moveheight = parseFloat($("#form_send_comment").offset().top);
        $('html, body').animate({
            scrollTop: moveheight - header_height - 10
        }, 1000);
    })

    $(document).on('click' , '#comment_btn' , function(){
        var this_btn_parent = $(this).parent();
        var b_id = $(this).attr('b_id');
        var pro_id = $('input[name=pro_id]').val();
        $.ajax({
            url : site_url + 'product/leavecomment' , 
            type: 'GET' , 
            data: {
                b_id : b_id , 
                pro_id : pro_id
            } , 
            success : function(response){
                console.log(response);
                this_btn_parent.html(response);
                var header_height = parseFloat($("body > .header").height());
                var moveheight = parseFloat(this_btn_parent.offset().top);
                $('html, body').animate({
                    scrollTop: moveheight - header_height - 10
                }, 1000);
            }
        })
    })

    $(document).on('change' , 'input[name=comment_image]' , function(){
        var this_dom = $(this);
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                this_dom.parents('.form-group').find('#preview_image').show();
                this_dom.parents('.form-group').find('#preview_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    })

    $(document).on('click' , '#addToFavorite' , function(){
        var pro_id = $('#pro_id').val();
        $.ajax({
            url : site_url + 'product/addToFavorite' , 
            type: 'POST' , 
            data: {
                pro_id : pro_id , 
            } , 
            dataType: 'json' , 
            success: function(response){
                if (response.success) {
                    toastr['success']('操作成功');
                }
                else {
                    toastr['error']('操作失败.');
                }
            }
        })
    })

    $(document).on('click' , '#loadMoreData_btn' , function(){
        loadBlogMoreData();
    })
    
    loadBlogMoreData();

    $(document).on('click' , '.go_shop' , function(){
        event.preventDefault();
        var href = $(this).attr('href');
        var seller_id = $(this).attr('seller-id');
        $.ajax({
            url: site_url + 'product/increaseShopVisitCount' , 
            type: 'POST' , 
            data: {
                seller_id: seller_id
            } , 
            success: function(response){
                location.href = href;
            }
        })
    })

</script>