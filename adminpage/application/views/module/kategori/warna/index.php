<div class="container-fluid" id="container-wrapper">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                    <div class="text-right">
                        <a href="" class="btn btn-primary btn-sm no-hov" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
                    </div>
                </div>
                <div class="table-responsive p-3 middle-tabel">
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Warna</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1; foreach ($all_data as $data) : 
                            ?>
                            <tr>
                                <td><?=$no;?></td>
                                <td><?= $data['nama_warna'];?></td>
                                <td align="right">
                                    <a href="javascript:prosesHapus('kategori/hapusWarna/<?=$data['warna_id'];?>');" class="btn btn-danger btn-sm font-size-12"><i class="fa fa-trash"></i></a>
                                    <a href="#" onclick="modalNormal('<?=base_url('kategori/editWarna/').$data['warna_id']?>')" class="btn btn-warning btn-sm font-size-12">Edit</a>
                                </td>
                            </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambahform" action="javascript:prosesDefault('kategori/warna/proses','tambahform')" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Nama Warna<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nama_warna" required="" autocomplete="off">
                            </div>
                        </div>
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