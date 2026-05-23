<?php $set_admin = $this->auth->getById('_setting','setting_id','1'); ?>
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
  <!-- // khusus point of sale -->
  <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3 d-block_ d-sm-none_ d-none_ d-sm-block_ d-md-none_">
    <i class="fa fa-bars"></i>
  </button>
  <ul class="navbar-nav ml-auto">

    <!-- <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ad fa-fw"></i>
        <span class="badge badge-success badge-counter">1+</span>
      </a>
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
          IKLAN PENDING
        </h6>
        <a class="dropdown-item d-flex align-items-center" href="javascript:">
          <div class="mr-3">
            <div class="icon-circle bg-primary">
              <i class="fas fa-user-plus text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">26 Jul 2020</div>
            <span class="font-weight-bold">Novel yang akan di iklankan</span>
          </div>
        </a>
        <a class="dropdown-item text-center small text-gray-500" href="javascript:">Lihat semua</a>
      </div>
    </li> -->

    <li class="nav-item dropdown no-arrow mx-1 d-none d-sm-block">
      <a class="nav-link" href="<?=base_url('transaksi/transaksi/');?>" data-toggle="tooltip" title="Transaksi Baru">
        <i class="fas fa-shopping-cart fa-fw"></i>
        <span class="badge badge-success badge-counter transaksibarutopbar">0+</span>
      </a>
    </li>
    <?php if($set_admin["fitur_saldo"]=='y'){ ?>
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link" href="<?=base_url('transaksi/tariksaldo/');?>" data-toggle="tooltip" title="Tarik Saldo - Menunggu Konfirmasi">
        <i class="fas fa-dollar-sign fa-fw"></i>
        <span class="badge badge-info badge-counter transaksipendingwdtopbar">0+</span>
      </a>
    </li>
    <?php } ?>
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link" href="<?=base_url('transaksi/pembayaran/');?>" data-toggle="tooltip" title="Sudah Bayar - Menunggu Konfirmasi">
        <i class="fas fa-money-bill fa-fw"></i>
        <span class="badge badge-danger badge-counter transaksipendingudhbyrtopbar">0+</span>
      </a>
    </li>

    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link" href="<?=base_url('transaksi/ulasan/');?>" data-toggle="tooltip" title="Ulasan & Rating Baru">
        <i class="fas fa-comment-alt fa-fw"></i>
        <span class="badge badge-warning badge-counter ulasanratingbarutopbar">0+</span>
      </a>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="img-profile rounded-circle" src="<?=base_url('assets/temp/');?>img/boy.png" style="max-width: 60px">
        <span class="ml-2 d-none d-lg-inline text-white small"><?=$auth['nama_lengkap'];?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalDataProfil">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profil
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?=base_url('auth/logout');?>">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Keluar
        </a>
      </div>
    </li>
  </ul>
</nav>
<!-- Topbar -->

<!-- <div class="pl-4 pr-4 pt-1 pb-2">
  <div class="alert alert-danger"> Dashboard admin dalam perbaikan (proses updating)... <img src="<?=base_url('assets/temp/');?>img/komponen/loading.gif"></div>
</div> -->

<!-- Modal -->
<div class="modal fade" id="modalDataProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editformprofilglob" action="javascript:prosesDefault('data/editAdmin/<?=$auth['pengelola_id'].'/prosesi'?>','editformprofilglob')" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap<span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="nama" required="" value="<?=$auth['nama_lengkap'];?>" autocomplete="off">
                        <?= form_error('nama','<small class="text-danger">','</small>');?>
                    </div>
                    <div class="form-group">
                        <label>Username<span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="name" value="<?=$auth['username'];?>" required="" autocomplete="off">
                        <?= form_error('name','<small class="text-danger">','</small>');?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="*****************" autocomplete="off">
                        <small class="form-text text-muted">Kosongkan jika tidak dirubah.</small>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">&nbsp;Submit&nbsp;</button>
                </div>
            </form>
        </div>
    </div>
</div>