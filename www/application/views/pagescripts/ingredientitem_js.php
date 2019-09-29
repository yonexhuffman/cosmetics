 <script type="text/javascript">   

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

    $(document).on('click' , '#comment_btn' , function(){
        var this_btn_parent = $(this).parent();
        var b_id = $(this).attr('b_id');
        var ing_id = $('#ing_id').val();
        $.ajax({
            url : site_url + 'ingredient/leavecomment' , 
            type: 'GET' , 
            data: {
                b_id : b_id , 
                ing_id : ing_id
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

    function loadBlogMoreData(){       
        var blog_last_id = $('#blog_last_id').val();
        if (parseInt(blog_last_id) >= 0) {
            var ing_id = $('#ing_id').val();
            $.ajax({
                url : site_url + 'ingredient/loadBlogMoreData' , 
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
                        $('#loadMoreData_btn').hide();
                    }
                }
            })
        }
    }

    $(document).on('click' , '#loadMoreData_btn' , function(){
        loadBlogMoreData();
    })
    
    loadBlogMoreData();

</script>