
<form method="POST" enctype="multipart/form-data" id="form_send_comment" action="<?=site_url('product/savecomment')?>">
    <input type="hidden" name="b_id" value="<?=$b_id?>">
    <input type="hidden" name="pro_id" value="<?=$pro_id?>">
    <div class="row margin-t10">
        <div class="col-sm-12 col-md-12 form-horizontal">
            <!-- <div class="form-group">
                <label class="control-label col-md-3">题目</label>
                <div class="col-md-9">
                    <input type="text" name="b_title" class="form-control" >
                </div>
            </div> -->
            <!-- <div class="form-group" style="display: flex;align-items: center;">
                <label class="control-label col-md-3" style="padding-top: 0;">评价分数</label>
                <div class="col-md-9">
                    <input type="range" value="5" step="0.25" name="b_user_rate" id="b_user_rate">
                    <div class="rateit" data-rateit-readonly="false" data-rateit-backingfld="#b_user_rate" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5"></div>
                </div>
            </div> -->
            <div class="form-group" style="text-align: left;">
                <label class="control-label col-md-3">内容</label>
                <div class="col-md-9">
                    <textarea name="b_content" class="form-control" rows="11"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-3">
                    <span class="btn cosmetic-btn  fileinput-button pull-right">
                    <i class="fa fa-file-picture-o"></i>
                    <span>
                    </span>
                    <input type="file" name="comment_image">
                    </span>
                </div>
                <div class="col-md-9">
                    <img id="preview_image" src="#" class="product_image" style="width: 100%;display: none;">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 text-center">
                    <button type="button" id="send_comment" class="btn btn-circle cosmetic-btn"><i class="fa fa-save"></i> 发布</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- <script src="<?php echo base_url('assets/global/plugins/rateit/src/jquery.rateit.js');?>" type="text/javascript"></script> -->