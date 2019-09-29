<div class="row">
    <div class="col-sm-0 col-md-2"></div>
    <div class="col-md-8 form"> 
        <form action="<?php echo site_url('admin/admininfo/update'); ?>" class="form-horizontal" method="post" id="update_form" enctype="multipart/form-data">
            <input type="hidden" name="acc_id" value="<?=$admindata['acc_id']?>" />
            <input type="hidden" id="cur_password" value="<?=$admindata['user_password']?>" />   
            <div class="form-group">
                <label class="control-label col-md-3">账号</label>
                <div class="col-md-7">
                    <input type="text" name="user_id" class="form-control" value="<?=$admindata['user_id']?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">旧密码</label>
                <div class="col-md-7">
                    <input type="password" id="prev_user_pass" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">新密码</label>
                <div class="col-md-7">
                    <input type="password" name="user_pass" id="user_pass" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">确认密码</label>
                <div class="col-md-7">
                    <input type="password" id="new_user_pass_confirm" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-success" id="btn_update" >更新</button>
                </div>
            </div>
        </form>
    </div>

</div>   