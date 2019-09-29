
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
			</div>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
        2018 &copy; <?=SCHOOLTITLE?>.
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url('assets/global/plugins/respond.min.js');?>"></script>
<script src="<?php echo base_url('assets/global/plugins/excanvas.min.js');?>"></script>
<![endif]-->
<script src="<?php echo base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/jquery-migrate.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/uniform/jquery.uniform.min.js');?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo base_url('assets/global/plugins/bootstrap-toastr/toastr.min.js');?>" type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- IMPORT PLUGIN JS -->
<?php
    if (isset($plugin_js) && is_array($plugin_js)) {
        foreach ($plugin_js as $key => $js) {
?>
<script src="<?php echo base_url('assets/global/plugins/' . $js);?>" type="text/javascript"></script>
<?php
        }
    }
?>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url('assets/global/scripts/metronic.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/layout/scripts/layout.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/layout/scripts/demo.js');?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
	function loadingstart(target_id){
	    Metronic.blockUI({
	        target: target_id ,
	        animate: true
	    });
	}
	function loadingend(target_id){
	    Metronic.unblockUI(target_id);
	}

	jQuery(document).ready(function() {     
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init();


		$(document).on('click' , '.btn_formsubmit' , function(){
			loadingstart('#body_container');
		});

		$(document).on('click' , '.open_newwindow' , function(){
			event.preventDefault();
			var url = $(this).attr('href');
			window.open(url);
		});
	});
<?php
    if (isset($post_result_alarm_message)){
        if ($post_result_alarm_message['success']) {
?>
            toastr['success']('操作成功.');
<?php
        }
        else {
?>
            toastr['error']('操作失败.');
<?php        
        }
    }
?>
</script>
<!-- END JAVASCRIPTS -->