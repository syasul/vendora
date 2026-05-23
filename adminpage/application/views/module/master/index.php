<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
  <div class="row mb-3">
    <div class="ol-xl-4 col-lg-4 col-md-4 col-sm-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Selamat Datang</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$auth['nama_lengkap'];?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Total User</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$t_cust;?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Total Produk</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$t_produk;?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-cubes fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4 mt-4">
      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Transaksi</div>
    </div>

    <div class="ol-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Baru</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$t_t_baru;?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-swatchbook fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Diproses & Menunggu Konfirmasi</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$t_t_proses;?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-swatchbook fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Selesai</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$t_t_selesai;?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-swatchbook fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Batal</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$t_t_batal;?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-swatchbook fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4 d-none">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Topup Pending</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$t_topup_baru;?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-swatchbook fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4 mt-4">
      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Statistik</div>
    </div>
    <div class="ol-xl-6 col-lg-6 col-md-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="font-weight-bold text-uppercase mb-1">Hari Ini</div>
              <div class="ft-14 mb-0 mr-3">
                <div class=""><b>Total Pengunjung : <?=$statistic_visitors['total_visitors']+0;?></b></div>
                <div class=""><b>Total Interaksi Halaman : <?=$statistic_visitors['total_visitors_pages']+0;?></b></div>
                <div class="text-success"><b>Pengunjung Hari Ini : <?=$statistic_visitors['today_visitors']+0;?></b></div>
                <div class="text-success"><b>Interaksi Halaman Hari Ini : <?=$statistic_visitors['visitors_pages']+0;?></b></div>
                <div class="text-success"><b>Online : <?=$statistic_visitors['online_visitors']+0;?></b></div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-chart-line fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-6 col-lg-6 col-md-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="font-weight-bold text-uppercase mb-2">
                <div class="mb-2">Filter</div>
                <input type="date" class="form-control" style="width:180px;" id="dateenddat" value="<?=$tglstatistik;?>" onchange="checkFilterStat(this.value)">
              </div>
              <div class="ft-14 mb-3 mr-3">
              <div class="text-success"><b>Pengunjung : <?=$statistic_visitors_filter['today_visitors']+0;?></b></div>
                <div class="text-success"><b>Interaksi Halaman : <?=$statistic_visitors_filter['visitors_pages']+0;?></b></div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-chart-line fa-2x text-dark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4">

      <div class="row">
        <div class="ol-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
          <div class="row">
            <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50 Produk Terlaris</div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <!-- <div class="font-weight-bold mb-3">25 Produk Terlaris</div> -->
                      <div class="table-responsive" style="max-height:350px; overflow-y: auto;">
                        <table class="table align-items-center table-flush table-hover">
                          <thead class="thead-light">
                            <tr>
                              <th>No</th>
                              <th>Produk</th>
                              <th>Terjual</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no=1; foreach ($bestseller as $data) : ?>
                            <tr>
                              <td><?=$no;?></td>
                              <td><?=$data["nama_produk"];?></td>
                              <td><?=$data["terjual"];?></td>
                            </tr>
                            <?php $no++; endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="ol-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
          <div class="row">
            <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50 Produk Stok Mau Habis</div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <!-- <div class="font-weight-bold mb-3">25 Produk Terlaris</div> -->
                      <div class="table-responsive" style="max-height:350px; overflow-y: auto;">
                        <table class="table align-items-center table-flush table-hover">
                          <thead class="thead-light">
                            <tr>
                              <th>No</th>
                              <th>Produk</th>
                              <th>Stok</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no=1; foreach ($stokhabis as $data) : ?>
                            <tr style="<?php if ($data["stok"]>25) echo ''; else echo 'color:red'; ?>">
                              <td><?=$no;?></td>
                              <td><?=$data["nama_produk"];?></td>
                              <td><?=formatRupiahnorp($data["stok"]+0);?></td>
                            </tr>
                            <?php $no++; endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="ol-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Pendapatan</div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-uppercase mb-1">
                    Total Pendapatan Bulan Ini
                  </div>
                  <div class="h5 mb-2 mr-3 font-weight-bold text-gray-800"><?=formatRupiah($pendapatan['harga']+$pendapatan['ongkir']+$pendapatan['tharga']-$pendapatan['potongan']-$pendapatan['d_all']-$pendapatan['voucher']+0);?></div>
                  <div class="h6 mb-0 mr-3 font-size-14">Termasuk Ongkir <b><?=formatRupiah($pendapatan['ongkir']+0);?></b></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-hand-holding-usd fa-2x text-dark"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-uppercase mb-1">
                    Total Pendapatan Bulan Lalu
                  </div>
                  <div class="h5 mb-2 mr-3 font-weight-bold text-gray-800"><?=formatRupiah($pendapatan_lalu['harga']+$pendapatan_lalu['ongkir']+$pendapatan_lalu['tharga']-$pendapatan_lalu['potongan']-$pendapatan_lalu['d_all']-$pendapatan_lalu['voucher']+0);?></div>
                  <div class="h6 mb-0 mr-3 font-size-14">Termasuk Ongkir <b><?=formatRupiah($pendapatan_lalu['ongkir']+0);?></b></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-hand-holding-usd fa-2x text-dark"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-4">
      <div class="card bg-app color-putih">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pendapatan - Semua Waktu</div>
              <div class="h5 mb-2 mr-3 font-weight-bold text-white-800"><?=formatRupiah($pendapatan_all['harga']+$pendapatan_all['ongkir']+$pendapatan_all['tharga']-$pendapatan_all['potongan']-$pendapatan_all['d_all']-$pendapatan_all['voucher']+0);?></div>
                  <div class="h6 mb-0 mr-3 font-size-14">Termasuk Ongkir <b><?=formatRupiah($pendapatan_all['ongkir']);?></b></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-hand-holding-usd fa-2x text-dark color-putih"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!---Container Fluid-->

<script>
  function checkFilterStat(a){
    document.location="<?=base_url('master/index/')?>"+a;
  }
</script>