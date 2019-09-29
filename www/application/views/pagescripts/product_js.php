 <script type="text/javascript">    
    $('#page_offset_num').val($('#productlist li.product_item').length);
    if ($('#page_offset_num').val() < 1) {
        $('#loadMoreData_btn').hide();
    }    

    function search(cat_id = ''){
        if (cat_id != '') {
            $('#cat_id').val(cat_id);
        }
        var suffix_url = '?';
        var condition = new Array;
        if ($('#cat_id').val() != '') {
            condition.push('category=' + $('#cat_id').val());
        }
        if ($('#search_form').val() != '') {
            condition.push('keyword=' + $('#search_form').val());
        }
        suffix_url += condition.join('&');
        if (condition.length > 0) {
            location.href = site_url + 'product?' + condition.join('&');
        }
        else {
            location.href = site_url + 'product';
        }
    }

    $(document).on('click' , '.btn_category' , function(event){
        event.preventDefault();
        var cat_id = $(this).attr('cat-id');
        search(cat_id);
    })

    $(document).on('keyup' , '#search_form' , function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            search();
        }
    })
    
    $(document).on('click' , '#btn_search' , function(){
        search();
    })

    var handleCategoryScroll = function(){
    	if ($(".product_category_scroll .active").offset().left < $(".product_category_scroll").width()) {
    		return;
    	}
    	$('.product_category_scroll').animate({
            scrollLeft: $(".product_category_scroll .active").offset().left - 20
        }, 1000);
    }

    // handleCategoryScroll();

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
            url : site_url + 'product/loadMoreData' , 
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
                if (typeof someObject == 'undefined') $.loadScript(base_url + 'assets/global/plugins/rateit/src/jquery.rateit.js', function(){
                    //Stuff to do after someScript has loaded
                });
                $('#page_offset_num').val(response.page_offset_num);
                $('#productlist').append(response.html);
                if (response.datacount < 1) {
                    $('#loadMoreData_btn').hide();
                    toastr['error']('没有结果');
                }

                loadingend();
            } , 
            error: function(error) {
                loadingend();
            }
        })
    }
</script>