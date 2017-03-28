<div class="row marketing">
    <div class="col-lg-12">
        <h4>Member Area</h4>

        <p><em>Welcome <?php echo $user['name'] ?></em></p>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="width: 150px">Nama</td>
                    <td><?php echo $user['name'] ?></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><?php echo $user['username'] ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="<?php echo site_url('member/profile') ?>" class="btn btn-success">Edit</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
