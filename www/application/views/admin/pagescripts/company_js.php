<script type="text/javascript">
    var grid = new Datatable();

    grid.init({
        src: $("#data_ajaxtable"),
        onSuccess: function (grid) {
            // execute some code after table records loaded
        },
        onError: function (grid) {
            // execute some code on network or other general error  
        },
        onDataLoad: function(grid) {
            // execute some code on ajax data load
        },
        loadingMessage: 'Loading...',
        dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
            
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "language": { // language settings
                // metronic spesific
                "metronicGroupActions": "_TOTAL_ records selected:  ",
                "metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",

                // data tables spesific
                "lengthMenu": "<span class='seperator'>|</span>显示 _MENU_ 行",
                "info": "<span class='seperator'>|</span>一共有 _TOTAL_ 个 商标",
                "infoEmpty": "No records found to show",
                "emptyTable": "No data available in table",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous": "上一个",
                    "next": "下一个",
                    "last": "Last",
                    "first": "First",
                    "page": "第",
                    "pageOf": "页"
                }
            },
            "columnDefs": [{ // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                'orderable': false,
                'targets': [1 , 6]
            }],
            "columns": [
                { name : 'com_id' } , 
                { name : '' } , 
                { name : 'com_name' } , 
                { name : 'com_alias' } , 
                { name : 'com_country' } , 
                { name : 'ranking_number' } , 
                { name : '' } , 
            ],
            "lengthMenu": [
                [20, 50, 100,],
                [20, 50, 100,] // change per page values here
            ],
            "pageLength": 20, // default record count per page
            "ajax": {
                "url": site_url + "admin/company/get_data", // ajax source
            },
            "order": [
                [0, "asc"]
            ]// set first column as a default sort by asc
        }
    });

    // handle group actionsubmit button click
    grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
        e.preventDefault();
        var action = $(".table-group-action-input", grid.getTableWrapper());
        if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
            grid.setAjaxParam("customActionType", "group_action");
            grid.setAjaxParam("customActionName", action.val());
            grid.setAjaxParam("id", grid.getSelectedRows());
            grid.getDataTable().ajax.reload();
            grid.clearAjaxParams();
        } else if (action.val() == "") {
            Metronic.alert({
                type: 'danger',
                icon: 'warning',
                message: 'Please select an action',
                container: grid.getTableWrapper(),
                place: 'prepend'
            });
        } else if (grid.getSelectedRowsCount() === 0) {
            Metronic.alert({
                type: 'danger',
                icon: 'warning',
                message: 'No record selected',
                container: grid.getTableWrapper(),
                place: 'prepend'
            });
        }
    });

    // function change_progress_bar(bar_id , bar_percent){
    //     $('#' + bar_id + ' .progress-bar').css('width' , bar_percent + '%');
    //     $('#' + bar_id + ' span').html(bar_percent + '%');
    // }

    // function create_interval(bar_id , interval) {
    //     $('#' + bar_id + ' span').html('1%');
    //     $('#' + bar_id + ' .progress-bar').removeClass('progress-bar-danger').addClass('progress-bar-primary');
    //     bar_percent = 1;
    //     timer_event = setInterval(function(){
    //         if (bar_percent <= 99) {
    //             change_progress_bar(bar_id , bar_percent);
    //             bar_percent ++; 
    //         }
    //     } , interval);
    // }

    // function stop_interval(success , bar_id){
    //     if (success) {
    //         change_progress_bar(bar_id , 100);
    //     }
    //     else {
    //         $('#' + bar_id + ' .progress-bar').removeClass('progress-bar-primary').addClass('progress-bar-danger');
    //     }
    //     clearTimeout(timer_event);
    // }

    // $(document).on('click' , '#reset_rankingnumber' , function(){
    //     create_interval('bar' , 10000);
    //     $.ajax({
    //         url : site_url + 'admin/company/decisionrankingnumber' , 
    //         type: 'POST' , 
    //         dataType: 'JSON' , 
    //         success: function(response){
    //             stop_interval(response.success , 'bar');
    //             if (response.success) {
    //                 location.href = site_url + 'admin/company';
    //             }
    //             else {
    //                 toastr['error']('操作失败.');
    //             }
    //         }
    //     })
    // })
    
<?php
    if ($is_reset_rankingnumber) {
?>
    // toastr['success']('#');
    // $('#reset_rankingnumber').trigger('click');
<?php
    }
?>

    // $(document).on('click' , '.btn-delete' , function(){
    // 	var com_id = $(this).parents('tr').attr('com-id');
    // 	var com_img = $(this).parents('tr').attr('image-name');
    // 	if (confirm('你真的想删除它吗？')) {
    // 		$.ajax({
    // 			url : site_url + 'admin/company/delete' , 
    // 			type: 'POST' , 
    // 			data: {
    // 				com_id : com_id , 
    // 				com_img : com_img
    // 			} , 
    // 			dataType: 'JSON' , 
    // 			success: function(response){
    // 				if (response.success) {
    // 					location.href = site_url + 'admin/company';
    // 				}
    // 				else {
    //                     toastr['error']('操作失败.');
    // 				}
    // 			}
    // 		})
    // 	}
    // })
</script>