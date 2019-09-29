 <script type="text/javascript">   
    $('#page_offset_num').val($('#productlist li').length);

    function search(){
        var keyword = $('#search_form').val();
        if (keyword == '') {
            location.href = site_url + 'ingredient';
        }
        else
            location.href = site_url + 'ingredient?keyword=' + keyword;
    }

    $(document).on('keyup' , '#search_form' , function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            search();
        }
    })

    $(document).on('click' , '#btn_search' , function(){
        search();
    })

    $(document).on('click' , '#loadMoreData_btn' , function(){
        loadMoreData();
    })

    function loadMoreData(){
        loadingstart();
        var page_offset_num = $('#page_offset_num').val(); 
        var cat_id = $('#cat_id').val(); 
        var ingredient = $('#ingredient').val(); 
        var keyword = $('#keyword').val(); 
        var companyid = $('#companyid').val(); 
        $.ajax({
            url : site_url + 'ingredient/loadMoreData' , 
            type: 'GET' , 
            data: {
                page_offset_num : page_offset_num , 
                cat_id : cat_id ,  
                ingredient : ingredient ,  
                keyword : keyword ,  
                companyid : companyid , 
            } , 
            dataType: 'json' , 
            success: function(response){
                $('#page_offset_num').val(response.page_offset_num);
                $('#productlist').append(response.html);
                if (response.datacount < 1) {
                    $('#loadMoreData_btn').hide();
                }

                loadingend();
            } , 
            error: function(error) {
                loadingend();
            }
        })
    }
</script>