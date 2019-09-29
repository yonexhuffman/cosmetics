 <script type="text/javascript">
    var per_page_count = '<?=LOADDATAPERPAGE?>';
    $('#page_offset_num').val($('#ratingproductlist li.product_item').length);
    if ($('#page_offset_num').val() < 1) {
        $('#loadMoreData_btn').hide();
    }    

    $(document).on('click' , '#loadMoreData_btn' , function(){
        loadMoreData();
    })

    function loadMoreData(){
        loadingstart();
        var page_offset_num = $('#page_offset_num').val(); 
        var page_index = $('#page_index').val();
        var cat_id = $('#cat_id').val(); 
        if (parseInt(page_offset_num) < 100) {
            $.ajax({
                url : site_url + 'rating/loadMoreData' , 
                type: 'POST' , 
                data: {
                    page_offset_num : page_offset_num , 
                    page_index : page_index , 
                    cat_id : cat_id ,  
                } , 
                dataType: 'json' , 
                success: function(response){
                    if (typeof someObject == 'undefined') $.loadScript(base_url + 'assets/global/plugins/rateit/src/jquery.rateit.js', function(){
                        //Stuff to do after someScript has loaded
                    });
                    $('#page_offset_num').val(response.page_offset_num);
                    $('#ratingproductlist').append(response.html);
                    if (parseInt(response.page_offset_num) >= 100) {
                        $('#loadMoreData_btn').hide();
                    }
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
    }

</script>