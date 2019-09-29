<script type="text/javascript">

	var total_scrapy_count = 0;
	var imported_product_percentvalue = 1;
	// var domestic_product_percentvalue = 1;

	var timer_event = null;
	// var product_timer_event = new Array;
	// var product_timer_percent = new Array;
	// var ingredient_timer_event = new Array;
	// var ingredient_timer_percent = new Array;

	function change_progress_bar(bar_id , bar_percent){
		$('#' + bar_id + ' .progress-bar').css('width' , bar_percent + '%');
		$('#' + bar_id + ' span').html(bar_percent + '%');
	}

	function create_interval(bar_id , interval) {
		$('#' + bar_id + ' span').html('1%');
		$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-danger').addClass('progress-bar-primary');
		imported_product_percentvalue = 1;
		timer_event = setInterval(function(){
			if (imported_product_percentvalue <= 99) {
				change_progress_bar(bar_id , imported_product_percentvalue);
				imported_product_percentvalue ++;	
			}
		} , interval);
	}

	function stop_interval(success , bar_id){
		if (success) {
			change_progress_bar(bar_id , 100);
		}
		else {
			$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-primary').addClass('progress-bar-danger');
		}
		clearTimeout(timer_event);
	}

    //     var result = $.ajax({
    //     type: 'POST',
    //     url: '../member.html',
    //     data: {ssl_login_check_pre:1, id:f.id.value, passwd:f.passwd.value, db:'gtime'},
    //     async: false
    // });
    // if(result.responseText.substring(0,2) == 'no') {
    //     document.getElementById('ErrorTextMsg').innerHTML = result.responseText.substring(3);
    //     f.id.focus();
    //     return;
    // } else if (result.responseText != 'ok') {
    //     f.id.focus();
    //     return;
    // }

	$(document).on('click' , '#scrapy_importedproduct' , function(){
		create_interval('progressbar_importedproduct' , 10000);
		var this_btn = $(this);
		// this_btn.attr('disabled' , true);

		$.ajax({
			url : site_url + 'admin/datascrapping/dailyscrap' , 
			type: 'POST' , 
			dataType: 'JSON' , 
			data: {
				scrap_step : 1
			} , 
			success: function(response){
				if (response.success) {
					scrap_step_second(response.categorylist , 0);	
				}
			}
		})
	})

	// var categorylist_index = 0;

	function scrap_step_second(categorylist , categorylist_index) {
		total_scrapy_count = 0;
		console.log('cat_new_id=' + categorylist[categorylist_index].cat_new_id + ' keyword=' + categorylist[categorylist_index].cat_sub_keyword);
		$.ajax({
			url : site_url + 'admin/datascrapping/dailyscrap' , 
			type: 'POST' , 
			dataType: 'JSON' , 
			data: {
				scrap_step : 2 , 
				cat_new_id : categorylist[categorylist_index].cat_new_id , 
				cat_sub_keyword : categorylist[categorylist_index].cat_sub_keyword , 
				end_page_number : categorylist[categorylist_index].end_page_number , 
				categorylist_index : categorylist_index
			} , 
			success: function(response) {
				if (response.success) {
					total_scrapy_count += parseInt(response.scrapy_product_total_count);
					console.log('scrapy_count = ' + response.scrapy_product_total_count);
				}	
				if (categorylist_index == (parseInt(categorylist.length) - 1)) {
					scrap_step_third(3);
				}
				else {
					categorylist_index ++;
					scrap_step_second(categorylist , categorylist_index);	
				}
			} , 
    		error: function(responseText){
    			console.log(responseText);
				if (categorylist_index == (parseInt(categorylist.length) - 1)) {
					scrap_step_third(3);
				}
				else {
					categorylist_index ++;
					scrap_step_second(categorylist , categorylist_index);	
				}
    		}
		})
	}

	function scrap_step_third(scrap_step){
		$.ajax({
			url : site_url + 'admin/datascrapping/dailyscrap' , 
			type: 'POST' , 
			dataType: 'JSON' , 
			data: {
				scrap_step : scrap_step , 
			} , 
			success: function(response){
				if (response.success) {
					total_scrapy_count += parseInt(response.scrapy_product_total_count);
					console.log('step=' + scrap_step + ' scrapy_count = ' + response.scrapy_product_total_count);
				}	
				if (scrap_step < 4) {
					scrap_step_third(4);
				}
				else {
					if (total_scrapy_count >= 0) {
						toastr['success']('操作成功. 新增项目-' + total_scrapy_count + '个');
						console.log('total_scrapy_count = ' + response.scrapy_product_total_count);
					}
					total_scrapy_count = 0;
					stop_interval(true , 'progressbar_importedproduct');
				}
			} , 
			error: function(response){
				if (scrap_step < 4) {
					scrap_step_third(4);
				}
				else {
					toastr['success']('操作成功. 新增项目-' + total_scrapy_count + '个');
					total_scrapy_count = 0;
					stop_interval(true , 'progressbar_importedproduct');
				}
			}
		})
	}

</script>