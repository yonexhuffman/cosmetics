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
                'targets': []
            }],
            "columns": [
                { name : 'seller_id' } , 
                { name : 'pro_title' } , 
                { name : 'seller_tb.shop_cat_id' } , 
                { name : 'shop_name' } , 
                { name : 'price' } , 
                { name : 'visit_count' } , 
            ],
            "lengthMenu": [
                [20, 50, 100,],
                [20, 50, 100,] // change per page values here
            ],
            "pageLength": 20, // default record count per page
            "ajax": {
                "url": site_url + "admin/visitcount/get_data", // ajax source
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
</script>