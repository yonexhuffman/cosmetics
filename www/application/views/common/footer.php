</div>
<!-- END PAGE CONTENT -->
<!-- BEGIN FOOTER -->
<!-- <div class="footer"> -->
    <!-- <div class="container text-center"> -->
        <!-- BEGIN COPYRIGHT -->
        <!-- <div class="row"> -->
            <!-- <div class="col-md-12 col-sm-12"> -->
               <!--2018 &copy;  -->
			   <!-- <p>@ 武汉智美无限信息科技有限公司 美丽修行</p> -->
			   <!-- <p>2018 bevol.cn 版权所有 ICP证：鄂15015954 网站导航</p> -->
            <!-- </div> -->
        <!-- </div> -->
        <!-- END COPYRIGHT -->
    <!-- </div> -->
<!-- </div> -->
<!-- END FOOTER -->
<div class="loading display-hide">
    <img src="<?=base_url('./uploads/bg/Loading_icon.gif')?>" width='30' height='30'>
    <!-- <span>它被装载</span> -->
</div>

<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="<?php echo base_url('assets/global/plugins/respond.min.js')?>"></script>
<![endif]--> 
<script src="<?php echo base_url('assets/global/plugins/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/jquery-migrate.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/custom/back-to-top.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/global/plugins/bootstrap-toastr/toastr.min.js');?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
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
<script src="<?php echo base_url('assets/frontend/layout/scripts/layout.js')?>" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();    
    });
    jQuery.loadScript = function (url, callback) {
        jQuery.ajax({
            url: url ,
            dataType: 'script',
            success: callback,
            async: true
        });
    }
    var fixPageContentHeight = function(){
        var windowHeight = $(window).height();
        var headerHeight = $('body .header').outerHeight();
        var footerHeight = $('body .footer').outerHeight();
        var pagecontentHeight = windowHeight - headerHeight - footerHeight;
        $('body .page-content').css('min-height' , pagecontentHeight);
    }
    function loadingstart(){
        $('.loading').show();
    }
    function loadingend(){
        $('.loading').hide();
    }

    fixPageContentHeight();

    /*jQuery(document).on('focusin' , 'input#search_form' , function(){
        $('.main-banner-title-search-center').css('border' , '2px solid #428bca');
    });

    jQuery(document).on('focusout' , 'input#search_form' , function(){
        $('.main-banner-title-search-center').css('border' , '2px solid #ddd');
    });*/
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
<!-- END PAGE LEVEL JAVASCRIPTS -->