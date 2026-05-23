    <style type="text/css">
        .modal { overflow: auto !important; }
    </style>

    <?php 

        if ($datas['is_active']==1) {
            $lbl = 'Aktif';
            $badge = 'badge-success';
        }else{
            $lbl = 'Tidak aktif';
            $badge = 'badge-primary';
        }

    ?>

    <div class="modal-header bg-35 border-radius0">
        <h5 class="modal-title color-putih" id="exampleModalLabel"><?= $datas['cust_nama'];?></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="color-putih">×</span>
        </button>
    </div>
    <div class="modal-body padding-0">
        
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="bg-putih border-radius5">
                    <div class="padding-15">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="float-left mr-3">
                                    <img src="<?=$this->config->item("nhub_url");?>assets/uploaded/profile/<?=$datas["cust_gambar"];?>" class="rounded" height="60">
                                </div>
                                <div class="f-bold">
                                    <?=$datas['cust_nama'];?> <span class="float-right badge <?=$badge;?>"><?=$lbl;?></span>
                                </div>
                                <div><?=$datas['is_token'];?></div>
                                <div class="font-size-12">Bergabung <?=indo($datas['created_at']);?> </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="">
                        <table class="table margin-bot-0">
                            <tbody>
                                <tr>
                                    <th class="f-bold">Riwayat :</th>
                                    <td class="color-primary cursor-pointer">Riwayat Transaksi &raquo;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                    <div class="">
                        <table class="table margin-bot-0">
                            <thead class="bg-35 color-putih">
                                <tr>
                                    <th colspan="2">Data Informasi</th>
                                </tr>
                            </thead>
                            <thead class="bg-35 color-putih">
                                <tr>
                                    <th colspan="2" class="font-size-12">Saldo <?=formatRupiah($saldo_user);?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="40%">Nama Lengkap</th>
                                    <td>: <?=$datas['cust_nama'];?></td>
                                </tr>
                                <tr>
                                    <th>No Ponsel</th>
                                    <td>: <?=$datas['cust_ponsel'];?></td>
                                </tr>
                                <tr>
                                    <th>Alamat Email</th>
                                    <td>: <?=$datas['is_token'];?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
    </div>