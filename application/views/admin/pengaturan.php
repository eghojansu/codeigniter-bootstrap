<div class="box">
    <div class="box-header">
        Pengaturan
    </div>
    <div class="box-body">
        <?php echo alert(validation_errors()) ?>

        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-2" for="app_name">Nama Aplikasi</label>
                <div class="col-md-4">
                    <input type="text" name="app_name" class="form-control" placeholder="Nama Aplikasi" value="<?php echo set_value('app_name', $this->setting->values['app_name']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="app_title">Judul Aplikasi</label>
                <div class="col-md-4">
                    <input type="text" name="app_title" class="form-control" placeholder="Judul Aplikasi" value="<?php echo set_value('app_title', $this->setting->values['app_title']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="app_alias">Alias Aplikasi</label>
                <div class="col-md-4">
                    <input type="text" name="app_alias" class="form-control" placeholder="Alias Aplikasi" value="<?php echo set_value('app_alias', $this->setting->values['app_alias']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="app_owner">Owner</label>
                <div class="col-md-4">
                    <input type="text" name="app_owner" class="form-control" placeholder="Owner" value="<?php echo set_value('app_owner', $this->setting->values['app_owner']) ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button class="btn btn-flat btn-primary" type="submit">Update</button>
                    <a href="<?php echo site_url('admin') ?>" class="btn btn-flat btn-default">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>



