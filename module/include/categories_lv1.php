    <div class="row justify-content-center pb-5 kategori_all_first">
        <div class="col-xl-10 col-lg-10 col-md-11">
        <div class="grid-magic-cg">
        <?php foreach($rest_kategori['result'] as $obj) { ?>
          <div class="main-grid-magic-cg">
            <div class="row m-0">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 p-0">
                <div class="bg-image-url p-5 h-100 border-kategori b-k-rounded box-shadow-v1" style="background: url('<?=$main_imgurl.'komponen/'.$obj['logo_image'];?>');">
                  <div class="title-kategori-2 font-weight-bold text-overflow-ellips">
                    <a href="<?=$main_url;?>c0/<?=$obj['url_kategori'];?>" style="color:<?=$obj['is_color'];?>!important;"><?=$obj['nama_kategori'];?></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
  </div>