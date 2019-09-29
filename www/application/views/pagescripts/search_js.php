 <script type="text/javascript">
 	var product_count_placeholder = '搜索 <?php echo isset($product_total_count) ? $product_total_count : '0'; ?> 种化妆品';
 	var ingredient_placeholder = '可以同时支持多成分搜索哦';

    jQuery(document).ready(function() {
        // LayersliderInit.initLayerSlider();
    });

    $(document).on('click' , '#search-tab-choose span' , function(){
    	$('#search-tab-choose span.active').removeClass('active');
    	$(this).addClass('active');

    	if ($(this).attr('name') == 'product') {
    		$('#search_form').attr('placeholder' , product_count_placeholder);
    	}
    	else {
    		$('#search_form').attr('placeholder' , ingredient_placeholder);
    	}
    })

    function search(){
        var search_type = $('#search-tab-choose span.active').attr('name');
        var keyword = $('#search_form').val();
        if (keyword == '') {
            alert('输入您的搜索字词');
            $('#search_form').focus();
            return;
        }
        if (search_type == 'product') {
            location.href = site_url + 'product?keyword=' + keyword;
        }
        else {
            location.href = site_url + 'ingredient?keyword=' + keyword;
        }
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
</script>