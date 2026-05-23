    <div class="row justify-content-center pb-5 kategori_all_first">
        <div class="col-xl-10 col-lg-10 col-md-11">
	      <div class="grid-magic-cg">
	      <?php foreach($rest_kategori['result'] as $obj) { ?>
	        <div class="main-grid-magic-cg box-shadow-v1 pb-4 b-rb-lb-15">
	          <div class="row m-0">
	            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 p-0 mb-3">
	              <div class="bg-image-url p-5 h-100 border-kategori b-k-0" style="background: url('<?=$main_imgurl.'komponen/'.$obj['logo_image'];?>');">
	                <div class="title-kategori-2 font-weight-bold text-overflow-ellips">
	                  <a href="<?=$main_url;?>c/<?=$obj['url_kategori'];?>" style="color:<?=$obj['is_color'];?>!important;"><?=$obj['nama_kategori'];?></a>
	                </div>
	              </div>
	            </div>
	            <?php 
	              $arr = array('tipeid' => 'id', 'idkategori' => $obj['kategori_id'], 'lang' => 'en');
	              $rest_det = loadData('rest_load/load_kategori_det/',$arr);
	            ?>
	            <?php $no=1; foreach($rest_det['result'] as $objx) { ?>
	            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <a href="<?=$main_url;?>c1/<?=$obj['url_kategori'];?>/<?=$objx['url_kategori'];?>">
                    	<div class="ft-16 mb-2 ml-3 mr-3">
	                    	<?=$objx['nama_kategori'];?> <span class="float-right"><i class="icon-angle-right"></i></span>
                    	</div>
	                </a>
                </div>
	            <?php $no++; } ?>
	          </div>
	        </div>
	      <?php } ?>
	      </div>
	  	</div>
	</div>