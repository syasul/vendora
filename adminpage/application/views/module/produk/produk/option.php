<?php if ($tipe=='sub') { ?>
  <label for="exampleInputEmail1">Sub Kategori <span class="font-size-12">- opsional</span></label>
  <select class="form-control selectpicker" data-max-options="5" name="kategori_sub_id[]" id="kategori_sub_id" data-live-search="true" multiple="" title="-- Pilih --" onchange="selectSub2();">
    <?php 
      foreach ($all_sub['result'] as $datasb) :
      $is = null; 
      if ($produk_id!=null) {
        $is = $this->auth->rowData('m_produk_kategori','produk_id='.$produk_id.' AND kategori_sub_id='.$datasb['kategori_sub_id']); 
      }
    ?>
    <option value="<?=$datasb['kategori_id'].'__'.$datasb['kategori_sub_id'];?>" <?php if ($is) echo 'selected'; ?>><?=$datasb['nama_kategori'];?> &nbsp;-&nbsp; <?=$datasb['nama_sub'];?></option>
    <?php endforeach; ?>
  </select>
	<script type="text/javascript">
		$(document).ready(function () {
	   $('.selectpicker').selectpicker();
	 });
	</script>
<?php } ?>

<?php if ($tipe=='sub_lv2') { ?>
  <label>Sub Lv2 <span class="font-size-12">- opsional</span></label>
  <select class="form-control selectpicker" name="kategori_sub_lv2_id[]" data-live-search="true" multiple="" title="-- Pilih --">
    <?php 
      foreach ($all_sub['result'] as $datasb) :
      $is = null; 
      if ($produk_id!=null) {
        $is = $this->auth->rowData('m_produk_kategori','produk_id='.$produk_id.' AND kategori_sub_id='.$datasb['kategori_sub_id'].' AND kategori_sub_lv2_id='.$datasb['kategori_sub_lv2_id']); 
      }
    ?>
    <option value="<?=$datasb['kategori_id'].'__'.$datasb['kategori_sub_id'].'__'.$datasb['kategori_sub_lv2_id'];?>" <?php if ($is) echo 'selected'; ?>><?=$datasb['nama_kategori'];?> &nbsp;-&nbsp; <?=$datasb['nama_sub'];?></option>
    <?php endforeach; ?>
  </select>
  <script type="text/javascript">
    $(document).ready(function () {
      $('.selectpicker').selectpicker();
    });
  </script>
<?php } ?>
