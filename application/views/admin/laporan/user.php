<div class="box">
    <div class="box-header">
        <h4>
            Data User
            <small class="visible-print">
                <br>
                Bulan: <?php echo bulan().' '.date('Y') ?>
            </small>
        </h4>

        <div class="btn-grup pull-right hidden-print">
            <button class="btn btn-flat btn-info" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($subset['items'])): ?>
                    <tr>
                        <td colspan="5">no record</td>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

