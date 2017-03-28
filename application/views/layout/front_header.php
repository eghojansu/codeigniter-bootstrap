
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url('favicon.ico') ?>">

    <title><?php echo $this->setting->values['app_title'] ?></title>

    <link href="<?php echo base_url('asset/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/plugins/select2/select2.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/plugins/timepicker/jquery.timepicker.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/dist/ie10-viewport-bug-workaround.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/dist/jumbotron-narrow.css') ?>" rel="stylesheet">

    <script src="<?php echo base_url('asset/plugins/jQuery/jquery-2.2.3.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
    <script src="<?php echo base_url('asset/plugins/timepicker/jquery.timepicker.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/plugins/select2/select2.full.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/plugins/jquery.backstretch.min.js') ?>"></script>
    <script src="<?php echo base_url('asset/dist/ie10-viewport-bug-workaround.js') ?>"></script>
    <script src="<?php echo base_url('asset/plugins/notifyjs/notify.js') ?>"></script>
    <script src="<?php echo base_url('asset/dist/front.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $.backstretch("<?php echo base_url('asset/img/fbg.jpg') ?>");
            <?php foreach ($flash as $type => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    $.notify('<?php echo $message ?>', {'className':'<?php echo $type ?>', 'position': 'top center'});
                <?php endforeach; ?>
            <?php endforeach; ?>
        })
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header clearfix hidden-print">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="<?php echo site_url('/') ?>"><i class="fa fa-home"></i> Home</a></li>
            <?php if ($user['login']): ?>
              <li role="presentation" class="dropdown">
                <?php $userNameLimit = 9; ?>
                <?php $moreThanLimit = strlen($user['name']) > $userNameLimit; ?>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user-o"></i> <?php echo $moreThanLimit?substr($user['name'], 0, $userNameLimit-2).'&hellip;' : $user['name'] ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li role="presentation"><a href="<?php echo site_url('member/index') ?>"><i class="fa fa-user"></i> Member Area</a></li>
                  <li role="presentation"><a href="<?php echo site_url('logout') ?>"><span class="text-danger"><i class="fa fa-power-off"></i> Logout</span></a></li>
                </ul>
              </li>
            <?php else: ?>
              <li role="presentation"><a href="<?php echo site_url('login') ?>"><span class="text-success"><i class="fa fa-lock"></i> Login</span></a></li>
            <?php endif; ?>
          </ul>
        </nav>
        <h3 class="text-muted"><?php echo $this->setting->values['app_title'] ?></h3>
      </div>
