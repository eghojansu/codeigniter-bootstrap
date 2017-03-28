<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->setting->values['app_title'] ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/iCheck/flat/blue.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/datepicker/datepicker3.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/select2/select2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/clusterize/clusterize.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/timepicker/jquery.timepicker.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/adminlte/css/skins/skin-blue.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/adminlte/css/AdminLTE.min.css') ?>">

  <script src="<?php echo base_url('asset/plugins/jQuery/jquery-2.2.3.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/slimScroll/jquery.slimscroll.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/fastclick/fastclick.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/select2/select2.full.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/input-mask/jquery.inputmask.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/input-mask/jquery.inputmask.date.extensions.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/input-mask/jquery.inputmask.extensions.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/input-mask/jquery.inputmask.numeric.extensions.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/iCheck/icheck.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/bootbox/bootbox.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/notifyjs/notify.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/add-clear/add-clear.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/clusterize/clusterize.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/plugins/timepicker/jquery.timepicker.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/adminlte/js/app.min.js') ?>"></script>
  <script src="<?php echo base_url('asset/dist/dashboard.js') ?>"></script>
  <script>
    $(document).ready(function() {
      <?php foreach ($flash as $type => $messages): ?>
        <?php foreach ($messages as $message): ?>
            $.notify('<?php echo $message ?>', {'className':'<?php echo $type ?>', 'position': 'top center'});
        <?php endforeach; ?>
      <?php endforeach; ?>
    });
  </script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo $this->setting->values['app_alias'] ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo $this->setting->values['app_title'] ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-circle-o"></i> <?php echo $user['name'] ?>
            </a>

            <ul class="dropdown-menu">
              <li class="user-header">
                <p><?php echo $user['name']; ?></p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('admin/profile') ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <?php foreach ($menu as $path => $item): ?>
            <?php $hasChild = (array_key_exists('items', $item) && count($item['items']) > 0) ?>
            <li class="<?php echo $path == $menu_active ? 'active' : null ?> <?php echo $hasChild ? 'treeview' : null ?>">
                <a href="<?php echo $path[0]==='#'? '#' : site_url($path) ?>">
                    <i class="fa fa-<?php echo $item['icon'] ?>"></i> <span><?php echo $item['label'] ?></span>
                    <?php if ($hasChild): ?>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    <?php endif; ?>
                </a>
                <?php if ($hasChild): ?>
                    <ul class="treeview-menu">
                        <?php foreach ($item['items'] as $pathChild => $itemChild): ?>
                            <li <?php echo $pathChild===$menu_active ? 'class="active"' : null ?>><a href="<?php echo site_url($pathChild) ?>"><i class="fa fa-circle-o"></i> <?php echo $itemChild['label'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">



