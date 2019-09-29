<form method="POST" enctype="multipart/form-data" id="form_send_comment" action="<?=site_url('ingredient/savecomment')?>">
    <input type="hidden" name="b_id" value="<?=$b_id?>">
    <input type="hidden" name="ing_id" value="<?=$ing_id?>">
    <div class="row margin-t10">
        <div class="col-sm-12 col-md-12 form-horizontal">
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