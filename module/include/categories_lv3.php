      <?php foreach($rest_kategori['result'] as $obj) { ?>
      <div class="row justify-content-center pb-5 kategori_all_first">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="row m-0 box-shadow-v1 pb-4 b-rt-rb-15">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 p-0">
              <div class="bg-image-url p-5 h-100 border-kategori" style="background: url('<?=$main_imgurl.'komponen/'.$obj['logo_image'];?>');">
                <div class="title-kategori font-weight-bold">
                  <a href="<?=$main_url;?>c/<?=$obj['url_kategori'];?>" style="color:<?=$obj['is_color'];?>!important;"><?=$obj['nama_kategori'];?></a>
                </div>
              </div>
            </div>
            <?php 
              $arr = array('tipeid' => 'id', 'idkategori' => $obj['kategori_id'], 'lang' => 'en');
              $rest_det = loadData('rest_load/load_kategori_det/',$arr);
            ?>
            <?php $no=1; foreach($rest_det['result'] as $objx) { ?>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
              <div class="padding-kategori">
                <div class="font-weight-bold ft-16 mb-1">
                  <a href="<?=$main_url;?>c1/<?=$obj['url_kategori'];?>/<?=$objx['url_kategori'];?>">
                    <?=$objx['nama_kategori'];?>
                  </a>
                </div>
                <div class="row">
                <?php 
                  $arr = array('tipeid' => 'id', 'tipeid_v2' => '', 'idkategori' => $obj['kategori_id'], 'idsubkategori' => $objx['kategori_sub_id'], 'lang' => 'en');
                  $rest_sub_det = loadData('rest_load/load_sub_kategori_det/',$arr);
                ?>
                <?php foreach($rest_sub_det['result'] as $objxx) { ?>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <div class="color-semidark-m ft-14">
                      <a href="<?=$main_url;?>c2/<?=$obj['url_kategori'];?>/<?=$objx['url_kategori'];?>/<?=$objxx['url_kategori'];?>">
                        <?=$objxx['nama_kategori'];?>
                      </a>
                    </div>
                  </div>
                <?php } ?>
                </div>
              </div>
            </div>
            <?php $no++; } ?>
          </div>
        </div>
      </div>
      <?php } ?>