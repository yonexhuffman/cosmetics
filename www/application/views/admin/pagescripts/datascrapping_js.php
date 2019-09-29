<script type="text/javascript">
	var page_index = 1;
	var bar_percent = 1;
	var timer_event = null;
	var product_timer_event = new Array;
	var product_timer_percent = new Array;
	var ingredient_timer_event = new Array;
	var ingredient_timer_percent = new Array;

	function change_progress_bar(bar_id , bar_percent){
		$('#' + bar_id + ' .progress-bar').css('width' , bar_percent + '%');
		$('#' + bar_id + ' span').html(bar_percent + '%');
	}

	function create_interval(bar_id , interval) {
		$('#' + bar_id + ' span').html('1%');
		$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-danger').addClass('progress-bar-primary');
		bar_percent = 1;
		timer_event = setInterval(function(){
			if (bar_percent <= 99) {
				change_progress_bar(bar_id , bar_percent);
				bar_percent ++;	
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

	function create_product_interval(cat_id , bar_id , interval){
		$('#' + bar_id + ' span').html('1%');
		$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-danger').addClass('progress-bar-primary');
		product_timer_percent[cat_id] = 1;
		product_timer_event[cat_id] = setInterval(function(){
			if (product_timer_percent[cat_id] <= 99) {
				change_progress_bar(bar_id , product_timer_percent[cat_id]);
				product_timer_percent[cat_id] ++;	
			}
		} , interval);
	}

	function stop_product_interval(success , cat_id , bar_id) {
		if (success) {
			change_progress_bar(bar_id , 100);
		}
		else {
			$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-primary').addClass('progress-bar-danger');
		}
		product_timer_percent[cat_id] = 0;
		clearTimeout(product_timer_event[cat_id]);
	}

	function create_ingredient_interval(cat_id , bar_id , interval){
		$('#' + bar_id + ' span').html('1%');
		$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-danger').addClass('progress-bar-primary');
		ingredient_timer_percent[cat_id] = 1;
		ingredient_timer_event[cat_id] = setInterval(function(){
			if (ingredient_timer_percent[cat_id] <= 99) {
				change_progress_bar(bar_id , ingredient_timer_percent[cat_id]);
				ingredient_timer_percent[cat_id] ++;	
			}
		} , interval);
	}

	function stop_ingredient_interval(success , cat_id , bar_id) {
		if (success) {
			change_progress_bar(bar_id , 100);
		}
		else {
			$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-primary').addClass('progress-bar-danger');
		}
		ingredient_timer_percent[cat_id] = 0;
		clearTimeout(ingredient_timer_event[cat_id]);
	}

	$(document).on('click' , '#scrape_category' , function(){
		create_interval('bar' , 100);
		$.ajax({
			url : site_url + 'admin/datascrapping/scrape_category' , 
			type: 'POST' , 
			dataType: 'JSON' , 
			success: function(response){
				stop_interval(response.success , 'bar');
				if (response.success) {
					alert(response.message);
					location.href = site_url + 'admin/datascrapping?page=1';
				}
				else {
					toastr['error'](response.message);
				}
			}
		})
	})

	$(document).on('click' , '.scrape_product' , function(){
		var cat_id = $(this).parents('tr').attr('cat-id');
		create_product_interval(cat_id , 'product_progressbar_' + cat_id , 20000);
		var this_btn = $(this);
		this_btn.attr('disabled' , true);

		$.ajax({
			url : site_url + 'admin/datascrapping/scrape_product' , 
			type: 'POST' , 
			dataType: 'JSON' , 
			data: {
				cat_id : cat_id
			} , 
			success: function(response){
				if (response.success) {
					toastr['success'](response.message);
					$('#product_table span.status_label_' + cat_id).removeClass('label-danger').addClass('label-success').html(response.message);
					$('#product_table span.log_datetime_' + cat_id).removeClass('label-danger').addClass('label-success').html(response.log_datetime);
				}
				else {
					this_btn.attr('disabled' , false);
					toastr['error'](response.message);
					$('#product_table span.status_label_' + cat_id).removeClass('label-success').addClass('label-danger').html(response.message);
				}
				stop_product_interval(response.success , cat_id , 'product_progressbar_' + cat_id);
			}
		})
	})

	var scrape_ingredient_result = null;
	var startpagenum = 0;
	var scrap_perdatacount = 2;

	function scrape_category(this_btn , cat_id , endpagenum , length , result_index){
		if (endpagenum == 0) {
			toastr['success']('没有产品。');
			stop_ingredient_interval(response.success , cat_id , 'ingredient_progressbar_' + cat_id);
		}
		else {
			$.ajax({
				url : site_url + 'admin/datascrapping/scrape_ingredient' , 
				type: 'GET' , 
				dataType: 'JSON' , 
				data: {
					cat_id : cat_id , 
					// start : 0 , 
					start : result_index * length , 
					length : length , 
					result_index : result_index
				} , 
				success: function(response){
					scrape_ingredient_result.push(response.success);
					if (scrape_ingredient_result.length < endpagenum) {
						ingredient_timer_percent[cat_id] = Math.round(scrape_ingredient_result.length * 100 / endpagenum);
						change_progress_bar('ingredient_progressbar_' + cat_id , ingredient_timer_percent[cat_id]);
					}
					else if (scrape_ingredient_result.length == endpagenum) {
						if (scrape_ingredient_result.indexOf(false) < 0) {
							toastr['success'](response.message);
							$('#ingredient_table span.status_label_' + cat_id).removeClass('label-danger').addClass('label-success').html(response.message);
							$('#ingredient_table span.log_datetime_' + cat_id).removeClass('label-danger').addClass('label-success').html(response.log_datetime);
						}	
						else {
							toastr['error'](response.message);
							$('#ingredient_table span.status_label_' + cat_id).removeClass('label-success').addClass('label-danger').html(response.message);
						}
						stop_ingredient_interval(response.success , cat_id , 'ingredient_progressbar_' + cat_id);
						$('#ingredient_table tbody tr').each(function(){
							$(this).find('td').last().find('.scrape_category_ingredient').attr('disabled' , false);
						})
					}				
					// 개수 0일떄 알람이 안뜬다
					console.log('status = ' + response.success , 'cat_id=' + cat_id , 'result_index=' + result_index , 'length=' + length , 'endpagenum=' +  endpagenum , ' percent= ' + ingredient_timer_percent[cat_id] + '%');

					if (response.result_index < endpagenum - 1) {
						response.result_index ++;
						scrape_category(this_btn , cat_id , endpagenum , length , response.result_index);	
					}
				} , 
				error: function(){
					scrape_ingredient_result.push(false);
					console.log('status = error_page cat_id=' + cat_id , 'result_index=' + result_index , 'length=' + length , 'endpagenum=' +  endpagenum , ' percent= ' + ingredient_timer_percent[cat_id] + '%');
					// stop_ingredient_interval(response.success , cat_id , 'ingredient_progressbar_' + cat_id);
					// $('#ingredient_table tbody tr').each(function(){
					// 	$(this).find('td').last().find('.scrape_category_ingredient').attr('disabled' , false);
					// })
					// scrape_category(this_btn , cat_id , endpagenum , length , result_index);	
					toastr['error']('网络连接失败。');
				}
			})
		}
	}

	$(document).on('click' , '#ingredient_table .scrape_category_ingredient' , function(){
		var cat_id = $(this).parents('tr').attr('cat-id');
		create_ingredient_interval(cat_id , 'ingredient_progressbar_' + cat_id , 500000);
		var this_btn = $(this);
		// this_btn.attr('disabled' , true);
		// $('#ingredient_table tbody tr').each(function(){
		// 	$(this).find('td').last().find('.scrape_category_ingredient').attr('disabled' , true);
		// })
		scrape_ingredient_result = new Array;		
		$.ajax({
			url : site_url + 'admin/datascrapping/get_product_total_count' , 
			type: 'GET' , 
			dataType: 'JSON' , 
			data: {
				cat_id : cat_id , 
			} , 
			success: function(response){
				var endpagenum = 0;
				if (endpagenum == 0) {
					endpagenum = parseInt(response.productcount / scrap_perdatacount);
					if (response.productcount % scrap_perdatacount > 0) {
						endpagenum ++;
					}	
				}
				console.log('scrapy start ------> cat_id=' + cat_id , 'productcount=' + response.productcount , 'scrap_perdatacount=' + scrap_perdatacount , 'endpagenum=' +  endpagenum , ingredient_timer_percent[cat_id] + '%');
				if ($('#ingredient_start_page_num').val() != '') {
					result_index = $('#ingredient_start_page_num').val();
				}
				else {
					result_index = 0;
				}
				scrape_category(this_btn , cat_id , endpagenum , scrap_perdatacount , result_index);
			}
		})
	})

</script>