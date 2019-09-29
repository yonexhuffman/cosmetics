<script type="text/javascript">
	var imported_product_percentvalue = 1;
	var domestic_product_percentvalue = 1;

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
		imported_product_percentvalue = 1;
		timer_event = setInterval(function(){
			if (imported_product_percentvalue <= 99) {
				change_progress_bar(bar_id , imported_product_percentvalue);
				imported_product_percentvalue ++;	
			}
		} , interval);
	}

	function create_domesticinterval(bar_id , interval) {
		$('#' + bar_id + ' span').html('1%');
		$('#' + bar_id + ' .progress-bar').removeClass('progress-bar-danger').addClass('progress-bar-primary');
		domestic_product_percentvalue = 1;
		timer_event = setInterval(function(){
			if (domestic_product_percentvalue <= 99) {
				change_progress_bar(bar_id , domestic_product_percentvalue);
				domestic_product_percentvalue ++;	
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

	var imported_product_allpagecount = 0;
	var imported_product_startpagenum = 0;
	var imported_product_scrapy_perpagecount = 2;
	var imported_product_cur_scrapy_totalcount = 0;

	$(document).on('click' , '#scrapy_importedproduct' , function(){
		create_interval('progressbar_importedproduct' , 30000);
		var this_btn = $(this);
		this_btn.attr('disabled' , true);
		$('#scrapy_importedproduct_detail').attr('disabled' , true);

		$.ajax({
			url : site_url + 'admin/datascrapping/get_importedproduct_pagecount' , 
			type: 'GET' , 
			dataType: 'JSON' , 
			data: {

			} , 
			success: function(response){
				console.log(response.pageBean);
				imported_product_allpagecount = response.pageBean.allPage;
				imported_product_cur_scrapy_totalcount = 0;
				imported_product_startpagenum = 0;

				console.log('Scrapy Start !');
				scrapy_importedproduct_list(imported_product_startpagenum , imported_product_startpagenum + imported_product_scrapy_perpagecount);
			}
		})
	})

	function scrapy_importedproduct_list(dataStartPageNum , dataEndPageNum) {
		$.ajax({
			url : site_url + 'admin/datascrapping/scrapy_importedproduct_list' , 
			type: 'GET' , 
			dataType: 'JSON' , 
			data: {
				dataStartPageNum : dataStartPageNum , 
				dataEndPageNum : dataEndPageNum , 
			} , 
			success: function(response){
				if (response.success) {
					imported_product_percentvalue = Math.round(response.dataEndPageNum * 100 / imported_product_allpagecount);
					change_progress_bar('progressbar_importedproduct' , imported_product_percentvalue);
					if (response.dataEndPageNum != imported_product_allpagecount) {
						console.log('start=' + response.dataStartPageNum , 'end=' + response.dataEndPageNum , 'scrapy_product_count=' + response.scrapy_product_count);
						if (parseInt(response.dataEndPageNum) + parseInt(imported_product_scrapy_perpagecount) <= parseInt(imported_product_allpagecount)) {
							startpagenum = response.dataEndPageNum;
							endpagenum = parseInt(response.dataEndPageNum) + parseInt(imported_product_scrapy_perpagecount)
						}
						else {
							startpagenum = response.dataEndPageNum;
							endpagenum = imported_product_allpagecount;
						}
						imported_product_cur_scrapy_totalcount = parseInt(imported_product_cur_scrapy_totalcount) + parseInt(response.scrapy_product_count);
						scrapy_importedproduct_list(startpagenum , endpagenum);
					}
					else {
						console.log('start=' + response.dataStartPageNum , 'end=' + response.dataEndPageNum , 'scrapy_product_count=' + response.scrapy_product_count);
						stop_interval(true , 'progressbar_importedproduct');
						$('#scrapy_importedproduct').attr('disabled' , false);
						$('#scrapy_importedproduct_detail').attr('disabled' , false);
						imported_product_cur_scrapy_totalcount = parseInt(imported_product_cur_scrapy_totalcount) + parseInt(response.scrapy_product_count);
						toastr['success']('操作成功. 新增项目-' + imported_product_cur_scrapy_totalcount + '个');
					}
				}
				else {
					imported_product_cur_scrapy_totalcount += response.scrapy_product_count;
					stop_interval(true , 'progressbar_importedproduct');
					$('#scrapy_importedproduct').attr('disabled' , false);
					$('#scrapy_importedproduct_detail').attr('disabled' , false);
					toastr['success']('操作成功. 新增项目-' + imported_product_cur_scrapy_totalcount + '个');
				}
			} , 
			error: function(){
				console.log('status=error' , 'start=' + dataStartPageNum , 'end=' + dataEndPageNum);
				scrapy_importedproduct_list(dataStartPageNum , dataEndPageNum);
				toastr['error']('网络连接失败。');
			}
		})
	}

	var imported_product_detail_scrapy_percount = 2;
	var imported_product_detail_cur_scrapy_totalcount = 0;

	$(document).on('click' , '#scrapy_importedproduct_detail' , function(){
		create_interval('progressbar_importedproduct_detail' , 30000);
		var this_btn = $(this);
		this_btn.attr('disabled' , true);
		$('#scrapy_importedproduct').attr('disabled' , true);

		$.ajax({
			url : site_url + 'admin/datascrapping/get_scrapy_importedproduct_detail_count' , 
			type: 'GET' , 
			dataType: 'JSON' , 
			data: {

			} , 
			success: function(response){
				console.log(response);
				var endpagenum = 0;
				if (endpagenum == 0) {
					endpagenum = parseInt(response.productcount / imported_product_detail_scrapy_percount);
					if (response.productcount % imported_product_detail_scrapy_percount > 0) {
						endpagenum ++;
					}	
				}
				console.log('scrapy start ------> productcount=' + response.productcount , 'length=' + imported_product_detail_scrapy_percount , 'endpagenum=' +  endpagenum , imported_product_percentvalue + '%');
				scrapy_importedproduct_detail(endpagenum , imported_product_detail_scrapy_percount , 0);
			}
		})
	})

	function scrapy_importedproduct_detail(endpagenum , length , result_index){
		if (endpagenum == 0) {
			toastr['success']('没有产品。');
			stop_interval(false , 'progressbar_importedproduct_detail');
			$('#scrapy_importedproduct').attr('disabled' , false);
			$('#scrapy_importedproduct_detail').attr('disabled' , false);
		}
		else {
			$.ajax({
				url : site_url + 'admin/datascrapping/scrapy_importedproduct_detail' , 
				type: 'GET' , 
				dataType: 'JSON' , 
				data: {
					start : 0 , 
					length : length , 
					result_index : result_index
				} , 
				success: function(response){
					if (response.success) {
						imported_product_detail_cur_scrapy_totalcount  = imported_product_detail_cur_scrapy_totalcount + parseInt(response.scrapy_product_count);
					}
					imported_product_percentvalue = Math.round((parseInt(response.result_index) + 1) * 100 / endpagenum);
					change_progress_bar('progressbar_importedproduct_detail' , imported_product_percentvalue);
					console.log('status = ' + response.success , 'result_index=' + result_index , 'length=' + length , 'endpagenum=' +  endpagenum , ' percent= ' + imported_product_percentvalue + '%');

					if (response.result_index < endpagenum - 1) {
						response.result_index ++;
						scrapy_importedproduct_detail(endpagenum , length , response.result_index);	
					}
					else {
						toastr['success']('操作成功. 新增项目-' + imported_product_detail_cur_scrapy_totalcount + '个');
						stop_interval(true , 'progressbar_importedproduct_detail');

						$('#scrapy_importedproduct').attr('disabled' , false);
						$('#scrapy_importedproduct_detail').attr('disabled' , false);
					}
				} , 
				error: function(){
					console.log('status = false' , 'result_index=' + result_index , 'length=' + length , 'endpagenum=' +  endpagenum , ' percent= ' + imported_product_percentvalue + '%');
					stop_interval(true , 'progressbar_importedproduct_detail');
					scrapy_importedproduct_detail(endpagenum , length , result_index);	
					toastr['error']('网络连接失败。');
				}
			})
		}
	}

	var domestic_product_allpagecount = 0;
	// var domestic_product_allpagecount = 1000;
	var domestic_product_startpagenum = 1;
	var domestic_product_scrapy_perpagecount = 2;
	var domestic_product_cur_scrapy_totalcount = 0;

	$(document).on('click' , '#scrapy_domesticproduct' , function(){
		create_domesticinterval('progressbar_domesticproduct' , 30000);
		var this_btn = $(this);
		this_btn.attr('disabled' , true);
		$('#scrapy_domesticproduct_detail').attr('disabled' , true);

		$.ajax({
			url : site_url + 'admin/datascrapping/get_domesticproduct_pagecount' , 
			type: 'GET' , 
			dataType: 'JSON' , 
			data: {

			} , 
			success: function(response){
				console.log(response.pageCount);
				domestic_product_cur_scrapy_totalcount = 0;
				domestic_product_allpagecount = response.pageCount;
				if ($('#startpagenum').val() != '' && Number.isInteger(parseInt($('#startpagenum').val()))) {
					domestic_product_startpagenum = parseInt($('#startpagenum').val());
				}
				if ($('#endpagenum').val() != '' && Number.isInteger(parseInt($('#endpagenum').val()))) {
					domestic_product_allpagecount = parseInt($('#endpagenum').val());
				}

				console.log('Scrapy Start !');
				scrapy_domesticproduct_list(domestic_product_startpagenum , domestic_product_startpagenum + domestic_product_scrapy_perpagecount);
			}
		})
	})

	function scrapy_domesticproduct_list(dataStartPageNum , dataEndPageNum) {
		$.ajax({
			url : site_url + 'admin/datascrapping/scrapy_domesticproduct_list' , 
			type: 'GET' , 
			dataType: 'JSON' , 
			data: {
				dataStartPageNum : dataStartPageNum , 
				dataEndPageNum : dataEndPageNum , 
			} , 
			success: function(response){
				if (response.success) {
					domestic_product_percentvalue = Math.round(response.dataEndPageNum * 100 / domestic_product_allpagecount);
					change_progress_bar('progressbar_domesticproduct' , domestic_product_percentvalue);
					if (response.dataEndPageNum == domestic_product_allpagecount) {
						console.log('start=' + response.dataStartPageNum , 'end=' + response.dataEndPageNum , 'scrapy_product_count=' + response.scrapy_product_count , 'exist_product_count=' + response.exist_product_count , 'skip_product_count=' + response.skip_product_count);
						stop_interval(true , 'progressbar_domesticproduct');
						$('#scrapy_domesticproduct').attr('disabled' , false);
						$('#scrapy_domesticproduct_detail').attr('disabled' , false);
						domestic_product_cur_scrapy_totalcount = parseInt(domestic_product_cur_scrapy_totalcount) + parseInt(response.scrapy_product_count);
						toastr['success']('操作成功. 新增项目-' + domestic_product_cur_scrapy_totalcount + '个');
					}
					else {
						console.log('start=' + response.dataStartPageNum , 'end=' + response.dataEndPageNum , 'scrapy_product_count=' + response.scrapy_product_count , 'exist_product_count=' + response.exist_product_count , 'skip_product_count=' + response.skip_product_count);
						if (parseInt(response.dataEndPageNum) + parseInt(domestic_product_scrapy_perpagecount) <= parseInt(domestic_product_allpagecount)) {
							startpagenum = parseInt(response.dataEndPageNum);
							endpagenum = parseInt(response.dataEndPageNum) + parseInt(domestic_product_scrapy_perpagecount)
						}
						else {
							startpagenum = parseInt(response.dataEndPageNum);
							endpagenum = domestic_product_allpagecount;
						}
						domestic_product_cur_scrapy_totalcount = parseInt(domestic_product_cur_scrapy_totalcount) + parseInt(response.scrapy_product_count);
						scrapy_domesticproduct_list(startpagenum , endpagenum);
					}
				}
				else {
					domestic_product_cur_scrapy_totalcount = parseInt(domestic_product_cur_scrapy_totalcount) + parseInt(response.scrapy_product_count);
					stop_interval(true , 'progressbar_domesticproduct');
					$('#scrapy_domesticproduct').attr('disabled' , false);
					$('#scrapy_domesticproduct_detail').attr('disabled' , false);
					toastr['success']('操作成功. 新增项目-' + domestic_product_cur_scrapy_totalcount + '个');
				}
			} , 
			error: function(){
				console.log('status=error' , 'start=' + dataStartPageNum , 'end=' + dataEndPageNum);
				alert('网络连接失败。');
				// scrapy_domesticproduct_list(dataStartPageNum , dataEndPageNum);
				// toastr['error']('网络连接失败。');
			}
		})
	}

	var domestic_product_detail_scrapy_percount = 2;
	var domestic_product_detail_cur_scrapy_totalcount = 0;

	$(document).on('click' , '#scrapy_domesticproduct_detail' , function(){
		create_interval('progressbar_domesticproduct_detail' , 30000);
		var this_btn = $(this);
		this_btn.attr('disabled' , true);
		$('#scrapy_domesticproduct').attr('disabled' , true);

		$.ajax({
			url : site_url + 'admin/datascrapping/get_scrapy_domesticproduct_detail_count' , 
			type: 'GET' , 
			dataType: 'JSON' , 
			data: {

			} , 
			success: function(response){
				var endpagenum = 0;
				if (endpagenum == 0) {
					endpagenum = parseInt(response.productcount / domestic_product_detail_scrapy_percount);
					if (response.productcount % domestic_product_detail_scrapy_percount > 0) {
						endpagenum ++;
					}	
				}
				console.log('scrapy start ------> productcount=' + response.productcount , 'length=' + domestic_product_detail_scrapy_percount , 'endpagenum=' +  endpagenum , domestic_product_percentvalue + '%');
				scrapy_domesticproduct_detail(endpagenum , domestic_product_detail_scrapy_percount , 0);
			}
		})
	})

	function scrapy_domesticproduct_detail(endpagenum , length , result_index){
		if (endpagenum == 0) {
			toastr['success']('没有产品。');
			stop_interval(false , 'progressbar_domesticproduct_detail');
			$('#scrapy_domesticproduct').attr('disabled' , false);
			$('#scrapy_domesticproduct_detail').attr('disabled' , false);
		}
		else {
			$.ajax({
				url : site_url + 'admin/datascrapping/scrapy_domesticproduct_detail' , 
				type: 'GET' , 
				dataType: 'JSON' , 
				data: {
					start : 0 , 
					length : length , 
					result_index : result_index
				} , 
				success: function(response){
					if (response.success) {
						domestic_product_detail_cur_scrapy_totalcount  = domestic_product_detail_cur_scrapy_totalcount + parseInt(response.scrapy_product_count);
					}
					domestic_product_percentvalue = Math.round((parseInt(response.result_index) + 1) * 100 / endpagenum);
					change_progress_bar('progressbar_domesticproduct_detail' , domestic_product_percentvalue);
					console.log('status = ' + response.success , 'result_index=' + result_index , 'length=' + length , 'endpagenum=' +  endpagenum , ' percent= ' + domestic_product_percentvalue + '%');

					if (response.result_index < endpagenum - 1) {
						response.result_index ++;
						scrapy_domesticproduct_detail(endpagenum , length , response.result_index);	
					}
					else {
						toastr['success']('操作成功. 新增项目-' + domestic_product_detail_cur_scrapy_totalcount + '个');
						stop_interval(true , 'progressbar_domesticproduct_detail');

						$('#scrapy_domesticproduct').attr('disabled' , false);
						$('#scrapy_domesticproduct_detail').attr('disabled' , false);
					}
				} , 
				error: function(){
					console.log('status = false' , 'result_index=' + result_index , 'length=' + length , 'endpagenum=' +  endpagenum , ' percent= ' + domestic_product_percentvalue + '%');
					stop_interval(true , 'progressbar_domesticproduct_detail');
					alert('网络连接失败。');
					// scrapy_domesticproduct_detail(endpagenum , length , result_index);	
					// toastr['error']('网络连接失败。');
				}
			})
		}
	}

</script>