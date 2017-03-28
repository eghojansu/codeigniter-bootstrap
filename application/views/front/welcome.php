<div id="welcome-carousel" class="carousel slide" data-ride="carousel">
    <?php $slide_count = 3; ?>
    <?php $slide_active = 0; ?>

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php for ($i = 0; $i < $slide_count; $i++): ?>
            <li data-target="#welcome-carousel" data-slide-to="<?php echo $i; ?>" <?php echo $slide_active==$i?'class="active"':null ?>></li>
        <?php endfor; ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php for ($i = 0; $i < $slide_count; $i++): ?>
            <div class="item <?php echo $slide_active==$i?'active':null ?>">
                <img src="<?php echo base_url('asset/img/slide_'.$i.'.jpg') ?>">
            </div>
        <?php endfor; ?>
    </div>
</div>

<div class="row marketing">
    <div class="col-lg-6">
        <h4>Welcome</h4>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum unde itaque dolor laboriosam, natus consequuntur sit expedita rem cupiditate? Soluta eaque, asperiores consectetur molestias adipisci, corporis amet veniam. Voluptate, animi.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam, consectetur, fuga? A necessitatibus dolor dignissimos quaerat mollitia, vel sit, fuga at veniam. Quidem, nisi consequatur reprehenderit debitis et in similique!</p>
    </div>

    <div class="col-lg-6">
        <h4>Jam Operasional</h4>

        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam (WIB)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Setiap hari (Senin-Minggu)</td>
                    <td>07:00 - 03:00</td>
                </tr>
            </tbody>
        </table>

        <div class="alert alert-info text-center">
            Hari Libur Nasional Tetap Buka!
        </div>
    </div>
</div>
