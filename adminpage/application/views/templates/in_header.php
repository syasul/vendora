<?php $role_id = $this->session->userdata('role_id'); ?>
<?php $set_admin = $this->auth->getById('_setting','setting_id','1'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
  <meta name="description" content="">
  <meta name="author" content="https://carvellonic.com">
  <title><?=$title;?></title>
  <link href="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$set_admin["favicon_image"];?>" rel="icon">
  <link href="<?=base_url('assets/temp/');?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url('assets/temp/');?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url('assets/temp/');?>css/ruang-admin.min.css" rel="stylesheet">
  <link href="<?=base_url('assets/temp/');?>css/styles.css" rel="stylesheet">
  <link href="<?=base_url('assets/temp/');?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?=base_url('assets/temp/');?>vendor/datepicker-1.9.0/css/bootstrap-datepicker3.css" rel="stylesheet">
  <link href="<?=base_url('assets/temp/');?>vendor/bootstrap-select.min.css" rel="stylesheet">
  <link href="<?=base_url('assets/temp/');?>vendor/jquery-confirm.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen" rel="stylesheet">

  <script src="<?=base_url('assets/temp/');?>vendor/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
  
  <style type="text/css">

  #selectborder .dropdown-toggle {
    border-color: #d1d3e2 !important;
    color: #353535;
  }

  .color-price {
    color: #ff6000 !important;
  }

  .disabled-x{
    pointer-events: none;
    opacity: 0.2;
  }

  .color-warning {
    color: #db8404 !important;
  }

  .td-line-through {
    text-decoration: line-through !important;
  }

  .padding-submit {
    padding: 5px 0px 20px 20px !important;
  }

  .padding-submit-2 {
    padding: 5px 0px 5px 20px !important;
  }

  i.blink, span.blink { animation: blink 1s linear infinite; }
  @keyframes blink{
    0% { opacity: 0; }
    50% { opacity: .5; }
    100% { opacity: 1; }
  }

  input[type="date"]::-webkit-inner-spin-button,
  input[type="date"]::-webkit-calendar-picker-indicator {
      display: none;
      -webkit-appearance: none;
  }

  .vertical-align-middle {
    vertical-align: middle !important;
  }

  .btn-xs {
    padding: 1px 5px !important;
    font-size: 12px !important;
    line-height: 1.5 !important;
    border-radius: 3px !important;
  }

  .background-pos-img {
    background-position: center center !important;
    background-size: cover !important;
    width: 115px;
    height: 115px;
    border-radius: 10px;
    display: inline-flex;
    margin-right: 5px;
    margin-bottom: 10px;
  }

  @media (max-width:991px) {
    .mt-mob-1rem {
      margin-top: 14px !important;
    }
    .text-center-mob {
      text-align: center !important;
    }
  }

  @media (max-width:768px) {
    .hidden-xs-y {
      display: none !important;
    }
  }

  </style>

</head>

<?php 
  // khusus point of sale
  if ($nmenu=='POS Kasir') { 
    $s1 = 'active'; $dxdiv1 = 'sidebar-toggled'; $dxdiv1a = 'toggled'; 
  }else{ 
    $s1 = ''; $dxdiv1='sidebar-toggled'; $dxdiv1a = ''; 
  } 
?>

<body id="page-top" class="<?=$dxdiv1;?>">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion_ <?=$dxdiv1a;?>" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url();?>">
        <div class="sidebar-brand-icon">
          <img src="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$set_admin["logo_image"];?>">
        </div>
        <!-- <div class="sidebar-brand-text mx-3">cStore</div> -->
      </a>
      <hr class="sidebar-divider my-0">
      <?php if ($title=='Dashboard') { $ac = 'active'; }else{ $ac = ''; } ?>
      <li class="nav-item <?=$ac;?>">
        <a class="nav-link" href="<?=base_url('master/index');?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <?php if ($set_admin['fitur_chat']=='y') { ?>
      <?php if ($title=='Live Chat') { $ac2 = 'active'; }else{ $ac2 = ''; } ?>
      <li class="nav-item <?=$ac2;?>">
        <a class="nav-link" href="<?=base_url('master/chat');?>">
          <i class="fas fa-fw fa-comment-alt"></i>
          <span>Live Chat</span>
        </a>
      </li>
      <?php } ?>
      <?php $menu = $this->menu->showMenu($role_id); if ($menu!='no') { ?>

      <?php $no=1; foreach ($menu as $m) : ?>
      <?php if ($nmenu == $m['nama_menu']){ $nmenusc = 'active'; $nmenush = 'show'; } else { $nmenusc = ''; $nmenush = ''; } ?>
      <li class="nav-item <?=$nmenusc;?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap<?=$no;?>"
          aria-expanded="true" aria-controls="collapseBootstrap<?=$no;?>">
          <i class="<?=$m['icon']; ?>"></i>
          <span><?=$m['nama_menu']; ?></span>
        </a>
        <div id="collapseBootstrap<?=$no;?>" class="collapse <?=$nmenush;?>" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="background: #d9d9d9 !important;">
          <div class="py-2 collapse-inner rounded" style="background: #d9d9d9 !important;">
            <!-- Sub Menu -->
            <?php $subMenu = $this->menu->showSubMenu($role_id,$m['menu_id']); ?>
            <?php foreach ($subMenu as $sm) : ?>
            <?php if ($title == $sm['nama_menu']){ $nmenusub = 'active'; } else { $nmenusub = ''; } ?>
            <a class="collapse-item <?=$nmenusub;?>" style="color:<?=$sm['color'];?>" href="<?=base_url($sm['link_url']);?>"><?=$sm['nama_menu'];?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </li>
      <?php $no++; endforeach; ?>
      <li class="nav-item <?=$ac;?>">
        <a class="nav-link" href="<?=base_url('auth/clearallCache');?>">
          <i class="fas fa-fw fa-exclamation"></i>
          <span>Clear All Cache</span>
        </a>
      </li>
      <?php } ?>
      <hr class="sidebar-divider">
      <div class="version margin-bot-15" id="version-ruangadmin"></div>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        
