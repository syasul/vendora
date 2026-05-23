<?php include "module/module.php"; ?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">

    <meta property="og:title" content="Kontak Kami - <?=$rest_sistem['result']['meta_title'];?>">
    <meta property="og:description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <?php if (file_exists($main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'])){ ?>
    <meta property="og:image" content="<?=$main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php }else{ ?>
    <meta property="og:image" content="<?=$main_imgurl.'logo/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php } ?>
    <meta property="og:url" content="<?=$main_url;?>contact-us">
    
    <?php include "module/include/style.php"; ?>

    <title>Kontak Kami - <?=$rest_sistem['result']['meta_title'];?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <style type="text/css">

  .contact-wrap iframe {
    width: 100% !important;
    height: 360px !important;
    border-radius: 10px;
  }

  .info-wrap-kontak .dbox p {
    color: #fff;
    margin-bottom: 0; }
    .info-wrap-kontak .dbox p span {
      font-weight: 600;
      color: #fff; }
    .info-wrap-kontak .dbox p a {
      color: #fff; }
  .info-wrap-kontak .dbox .icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1); }
    .info-wrap-kontak .dbox .icon span {
      font-size: 20px;
      color: #fff; }
  .info-wrap-kontak .dbox .text {
    width: calc(100% - 50px); }

    </style>

    <section class="bg-container-2 mt-4 mb-3">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; Kontak Kami &mdash;
          </div>
        </div>
      </div>

      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mb-2">
          <div class="d-flex align-items-stretch">
            <div class="info-wrap-kontak bg-primary w-100 p-4 rounded-2">
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="dbox d-flex_ w-100 align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center" style="position: absolute;">
                      <span class="fa fa-map-marker"></span>
                    </div>
                    <div class="text" style="padding-left: 65px">
                      <p><span>Alamat</span><br/>
                        <?=$rest_sistem['result']['kontak_kami'];?>
                      </p>
                    </div>
                  </div>
                </div>
                <?php if ($rest_sistem['result']['call_center']!=''){ ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-phone"></span>
                    </div>
                    <div class="text pl-3">
                      <p><span>Telepon</span><br/>
                        <a href="tel:<?=$rest_sistem['result']['call_center'];?>"><?=$rest_sistem['result']['call_center'];?></a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($rest_sistem['result']['call_center2']!=''){ ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-phone"></span>
                    </div>
                    <div class="text pl-3">
                      <p><span>Telepon 2</span><br/>
                        <a href="tel:<?=$rest_sistem['result']['call_center2'];?>"><?=$rest_sistem['result']['call_center2'];?></a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($rest_sistem['result']['whatsapp']!=''){ ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-whatsapp"></span>
                    </div>
                    <div class="text pl-3">
                      <p><span>WhatsApp</span><br/>
                        <a href="https://api.whatsapp.com/send?phone=<?=$rest_sistem['result']['whatsapp'];?>&amp;text=" target="_blank">
                          +<?=substr($rest_sistem['result']['whatsapp'],0,2)." ".substr($rest_sistem['result']['whatsapp'],2,3)." ".substr($rest_sistem['result']['whatsapp'],5,4)." ".substr($rest_sistem['result']['whatsapp'],9,10);?>
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($rest_sistem['result']['whatsapp2']!=''){ ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-whatsapp"></span>
                    </div>
                    <div class="text pl-3">
                      <p><span>WhatsApp 2</span><br/>
                        <a href="https://api.whatsapp.com/send?phone=<?=$rest_sistem['result']['whatsapp2'];?>&amp;text=" target="_blank">
                          +<?=substr($rest_sistem['result']['whatsapp2'],0,2)." ".substr($rest_sistem['result']['whatsapp2'],2,3)." ".substr($rest_sistem['result']['whatsapp2'],5,4)." ".substr($rest_sistem['result']['whatsapp2'],9,10);?>
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($rest_sistem['result']['instagram']!=''){ ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-instagram"></span>
                    </div>
                    <div class="text pl-3">
                      <p><span>Instagram</span><br/>
                        <a href="<?=$rest_sistem['result']['instagram'];?>" target="_blank">Link Instagram</a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($rest_sistem['result']['facebook']!=''){ ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-facebook"></span>
                    </div>
                    <div class="text pl-3">
                      <p><span>Facebook</span><br/>
                        <a href="<?=$rest_sistem['result']['facebook'];?>" target="_blank">Link Facebook</a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if ($rest_sistem['result']['email_address']!=''){ ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="dbox w-100 d-flex align-items-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                      <span class="fa fa-paper-plane"></span>
                    </div>
                    <div class="text pl-3">
                      <p><span>Email</span><br/>
                        <a href="mailto:<?=$rest_sistem['result']['email_address'];?>"><?=$rest_sistem['result']['email_address'];?></a>
                      </p>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 col-lg-7 col-md-5 mb-2 mt-2">
          <div class="contact-wrap">
            <?=$rest_sistem['result']['google_maps'];?>
          </div>
        </div>
      </div>

    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

  </body>
</html>