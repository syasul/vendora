<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-xl-4 col-lg-5">
			<div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Filter</h6>
                </div>
                <div class="p-3">
                    <div class="form-group">
                      <label>Produk<span style="color: red">*</span></label>
                      <select class="form-control selectpicker" data-live-search="true" id="produk_id">
                        <?php foreach ($all_data as $datarl) : ?>
                        <option value="<?=$datarl['produk_id'];?>"><?=$datarl['nama_produk'];?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                              <label>Tanggal Awal</label>
                              <input type="date" name="awal_filter_st" class="form-control" id="startcon" value="<?=date('Y-m-01');?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                              <label>Tanggal Akhir</label>
                              <input type="date" name="akhir_filter_st" class="form-control" id="endcon" value="<?=date('Y-m-d');?>">
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <a href="javascript:onKeyup('produk/riwayat_stok/'+produk_id.value+'/'+startcon.value+'/'+endcon.value,'riwayat_stok_res')" class="btn btn-light btn-block">Lihat Riwayat Stok</a>
                        <!-- <a href="javascript:" class="btn btn-info btn-block">Download Semua Riwayat Stok</a>
                        <div class="font-size-12 mt-2">Download berupa file dengan format ms.excel</div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                </div>
                <div class="p-3">
                    <div id="riwayat_stok_res"></div>
                </div>
            </div>
        </div>
    </div>
</div>