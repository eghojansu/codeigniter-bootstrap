<div class="box">
    <div class="box-header">
        <h4>Data User</h4>

        <div class="btn-grup pull-right">
            <a href="<?php echo site_url($homePath.'/create') ?>" class="btn btn-flat btn-primary"><i class="fa fa-plus"></i> New Item</a>
        </div>
        <form class="form-inline form-search">
            <div class="form-group">
                <label for="keyword" class="sr-only">Name</label>
                <input type="text" class="form-control" value="<?php echo $keyword ?>" name="keyword" placeholder="Name" data-provide="clearbutton">
            </div>
            <button type="submit" class="btn btn-flat btn-default"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Roles</th>
                    <th>Username</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($subset['recordCount'] == 0): ?>
                    <tr>
                        <td colspan="6">no record</td>
                    </tr>
                <?php endif; ?>

                <?php $no = $subset['firstNumber'] + 1 ?>
                <?php $active = $this->config->item('app_active') ?>
                <?php foreach ($subset['items'] as $item): ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $item['name'] ?></td>
                        <td><?php echo $item['roles'] ?></td>
                        <td><?php echo $item['username'] ?></td>
                        <td><?php echo array_search($item['active'], $active) ?></td>
                        <td>
                            <a href="<?php echo site_url($homePath.'/update/'.$item['id']) ?>" class="btn btn-flat btn-xs btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="<?php echo site_url($homePath.'/delete/'.$item['id']) ?>" class="btn btn-flat btn-xs btn-danger" data-action="delete">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <?php $this->load->view('layout/pagination', ['pagination'=>$subset]) ?>
    </div>
</div>

