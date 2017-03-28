<div class="box">
    <div class="box-header">
        Update Profile
    </div>
    <div class="box-body">
        <?php echo alert(validation_errors()) ?>

        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-2" for="password">Password</label>
                <div class="col-md-3">
                    <input type="password" name="password" class="form-control" placeholder="Password lama">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label class="control-label col-md-2" for="username">Username</label>
                <div class="col-md-4">
                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username', $user['username']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="name">Name</label>
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo set_value('name', $user['name']) ?>">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <label class="control-label col-md-2" for="newPassword">Password Baru</label>
                <div class="col-md-3">
                    <input type="password" name="newPassword" class="form-control" placeholder="Password baru">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button class="btn btn-flat btn-primary" type="submit">Update</button>
                    <button class="btn btn-flat btn-default" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>



