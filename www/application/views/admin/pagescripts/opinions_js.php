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
                "info": "<span class='seperator'>|</span>一共有 _TOTAL_ 个 产品",
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
                'targets': [2 , 5]
            }],
            "columns": [
                { name : 'op_id' } , 
                { name : 'tbl_account.user_nickname' } , 
                { name : '' } , 
                { name : 'send_datetime' } , 
                { name : 'is_adminchecked' } , 
                { name : '' } , 
            ],
            "lengthMenu": [
                [20, 50, 100,],
                [20, 50, 100,] // change per page values here
            ],
            "pageLength": 20, // default record count per page
            "ajax": {
                "url": site_url + "admin/opinions/get_data", // ajax source
            },
            "order": [
                [3, "desc"]
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

    $('.fancybox').fancybox({
        minWidth : 800 , 
        width : 800
    });

    $(document).on('click' , '.opinion_view' , function(){
        var op_id = $(this).attr('op-id');
        $.ajax({
            url : site_url + 'admin/opinions/itemcheck' , 
            type: 'POST' , 
            data: {
                op_id : op_id , 
            } , 
            dataType: 'JSON' , 
            success: function(response){
                if (response.success) {
                    grid.getDataTable().ajax.reload(function(){

                    }, true);
                }
            }
        })
    })

    $(document).on('click' , '.btn-delete' , function(){
    	var op_id = $(this).attr('op-id');
    	if (confirm('你真的想删除它吗？')) {
    		$.ajax({
    			url : site_url + 'admin/opinions/delete' , 
    			type: 'POST' , 
    			data: {
    				op_id : op_id , 
    			} , 
    			dataType: 'JSON' , 
    			success: function(response){
    				if (response.success) {
                        grid.getDataTable().ajax.reload();
                        toastr['success']('操作成功.');
                    }
                    else {
                        toastr['error']('操作失败.');
                    }
    			}
    		})
    	}
    })
</script>