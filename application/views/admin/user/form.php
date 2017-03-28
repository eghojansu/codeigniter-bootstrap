<div class="box">
    <div class="box-header">
        <h4>Data User <small><?php echo isset($old)?'Edit #'.$old['id']:'New Item' ?></small></h4>
    </div>
    <div class="box-body">
        <?php echo alert(validation_errors()) ?>

        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-2" for="name">Name</label>
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo set_value('name', ((isset($old) && array_key_exists('name', $old))?$old['name']:null)) ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="roles">Roles</label>
                <div class="col-md-4">
                    <?php $currentRole = set_value('roles', ((isset($old) && array_key_exists('roles', $old))?$old['roles']:null)) ?>
                    <?php foreach ($userRoles as $role): ?>
                        <div class="radio">
                            <label>
                                <input type="radio" name="roles" value="<?php echo $role ?>" <?php echo $currentRole==$role?'checked':null ?>> <?php echo $role; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="username">Username</label>
                <div class="col-md-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username', ((isset($old) && array_key_exists('username', $old))?$old['username']:null)) ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="password">Password</label>
                <div class="col-md-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="active">Active</label>
                <div class="col-md-4">
                    <?php $active = set_value('active', ((isset($old) && array_key_exists('active', $old))?$old['active']:null)) ?>
                    <?php foreach ($this->config->item('app_active') as $label => $value): ?>
                        <div class="radio">
                            <label>
                                <input type="radio" name="active" value="<?php echo $value ?>" <?php echo $value==$active?'checked':null ?>> <?php echo $label; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button class="btn btn-flat btn-primary" type="submit">Save</button>
                    <a href="<?php echo site_url($homePath) ?>" class="btn btn-flat btn-default">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>



