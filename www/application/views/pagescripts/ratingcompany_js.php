 <script type="text/javascript">
    var per_page_count = '<?=LOADDATAPERPAGE?>';
    $('#page_offset_num').val($('#ratingproductlist li').length);

    $(document).on('click' , '#loadMoreData_btn' , function(){
        loadMoreData();
    })

    function loadMoreData(){   
        loadingstart(); 
        var page_offset_num = $('#page_offset_num').val(); 
        var page_index = $('#page_index').val();
        if (parseInt(page_offset_num) < 100) {
            $.ajax({
                url : site_url + 'rating/loadMoreData' , 
                type: 'POST' , 
                data: {
                    page_offset_num : page_offset_num , 
                    page_index : page_index , 
                } , 
                dataType: 'json' , 
                success: function(response){
                    $('#page_offset_num').val(response.page_offset_num);
                    $('#ratingproductlist').append(response.html);
                    if (parseInt(response.page_offset_num) >= 100) {
                        $('#loadMoreData_btn').hide();
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