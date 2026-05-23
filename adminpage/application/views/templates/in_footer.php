      </div>
      <?php if ($nmenu!='POS Kasir') { // khusus point of sale ?>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - powered by
              <b><a href="https://cgdev.my.id/" target="_blank">cgdev</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
      <?php } ?>
    </div>
  </div>

  <style type="text/css">
    .full_modal-dialog {
      width: 98% !important;
      height: 92% !important;
      min-width: 98% !important;
      min-height: 92% !important;
      max-width: 98% !important;
      max-height: 92% !important;
      padding: 0 !important;
    }

    /*.full_modal-content {
      height: 99% !important;
      min-height: 99% !important;
      max-height: 99% !important;
    }*/
  </style>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <div class="modal fade" id="myModalnormal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="optionnormal"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <div class="modal fade" id="myModalnormal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="optionnormal2"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <div class="modal fade" id="myModalnormal3" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="optionnormal3"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <div class="modal fade" id="myModalsedang" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="optionsedang"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <div class="modal fade" id="myModalsedang2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="optionsedang2"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <div class="modal fade" id="myModalbesar" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content " id="optionbesar"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <div class="modal fade" id="myModalfull" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog full_modal-dialog" role="document">
        <div class="modal-content " id="optionfull"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <div class="modal fade" id="myModalfull2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog full_modal-dialog" role="document">
        <div class="modal-content " id="optionfull2"><span style="padding: 15px;">Loading...</span></div>
    </div>
  </div>

  <script src="<?=base_url('assets/temp/');?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="<?=base_url('assets/temp/');?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/datepicker-1.9.0/js/bootstrap-datepicker.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/tinymce/tinymce/tinymce.min.js"></script>

  <!-- <script src="<?=base_url('assets/temp/');?>vendor/jSignature/libs/jSignature.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/jSignature/libs/modernizr.js"></script> -->
  <script src="<?=base_url('assets/temp/');?>js/ruang-admin.min.js"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->  
  <script src="<?=base_url('assets/temp/');?>vendor/bootstrap-select.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/jquery-confirm.min.js"></script>
  
  <!--[if lt IE 9]>
    <script src="<?=base_url('assets/temp/');?>vendor/jSignature/libs/flashcanvas.js">"></script>
  <![endif]-->

  <script>

    var loadingimg = '<img src="<?=base_url('assets/temp/');?>img/komponen/loading.gif">';

    $(document).ready(function () {

      // khusus point of sale (digaian css juga ada yg diganti)
      if ($(window).width()<=768) {
        $('#page-top').removeClass('sidebar-toggled');
        $('#accordionSidebar').removeClass('toggled');
      }

      $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
      });

      $('.selectpicker').selectpicker();

      $('.selectpicker_limit').selectpicker({
        maxOptions : 3
      });

      $('[data-toggle="tooltip"]').tooltip();
      $('[data-toggle="popover"]').popover();
      
      $('#dataTable').DataTable({
        ordering: false,
        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "All"]]
      }); // ID From dataTable 
      $('#default').datepicker({
        format: "yyyy-mm-dd",
        autoclose:true
      });
      $('#startcon').datepicker({
        format: "yyyy-mm-dd",
        autoclose:true
      });
      $('#endcon').datepicker({
        format: "yyyy-mm-dd",
        autoclose:true
      });
      $('#dateenddat').datepicker({
        format: "yyyy-mm-dd",
        autoclose:true,
        endDate: "today"
      });

      cekTransaksibaru();
      cekTransaksipendingudahbayar();
      cekTransaksiautobatal();
      cekWdbaru();

    });

    function cekTransaksibaru(){
      $.ajax({
        url: "<?=base_url()?>auth/cek_transaksi_baru",
        cache: false,
        success: function(msg){
          $(".transaksibarutopbar").html(msg+'+');
        }
      });
      setTimeout("cekTransaksibaru()",10000);
    }

    function cekWdbaru(){
      $.ajax({
        url: "<?=base_url()?>auth/cek_wd_baru",
        cache: false,
        success: function(msg){
          $(".transaksipendingwdtopbar").html(msg+'+');
        }
      });
      setTimeout("cekWdbaru()",10000);
    }

    function cekTransaksipendingudahbayar(){
      $.ajax({
        url: "<?=base_url()?>auth/cek_transaksi_pending_udah_bayar",
        cache: false,
        success: function(msg){
          $(".transaksipendingudhbyrtopbar").html(msg+'+');
        }
      });
      setTimeout("cekTransaksipendingudahbayar()",10000);
    }

    function cekTransaksiautobatal(){
      $.ajax({
        url: "<?=base_url()?>auth/cek_transaksi_auto_batal",
        cache: false,
        success: function(msg){ }
      });
      setTimeout("cekTransaksiautobatal()",5000);
    }

    function modalNormal(a,b){
      $('#optionnormal').html('<span style="padding: 15px;">Loading...</span>');      
      $('#myModalnormal').css("z-index", b);
      $('#myModalnormal').modal('toggle');
      formNormal(a);
    }

    function formNormal(a) {
      $.get(a, function(data) {
        $('#optionnormal').html(data);
      });
    }

    function modalNormal2(a,b){
      $('#optionnormal2').html('<span style="padding: 15px;">Loading...</span>');
      $('#myModalnormal2').css("z-index", b);
      $('#myModalnormal2').modal('toggle');
      formNormal2(a);
    }

    function formNormal2(a) {
      $.get(a, function(data) {
        $('#optionnormal2').html(data);
      });
    }

    function modalNormal3(a,b){
      $('#optionnormal3').html('<span style="padding: 15px;">Loading...</span>');      
      $('#myModalnormal3').css("z-index", b);
      $('#myModalnormal3').modal('toggle');
      formNormal3(a);
    }

    function formNormal3(a) {
      $.get(a, function(data) {
        $('#optionnormal3').html(data);
      });
    }

    function modalSedang(a,b){
      $('#optionsedang').html('<span style="padding: 15px;">Loading...</span>');
      $('#myModalsedang').css("z-index", b);
      $('#myModalsedang').modal('toggle');
      formSedang(a);
    }

    function formSedang(a) {
      $.get(a, function(data) {
        $('#optionsedang').html(data);
        alertProses();
      });
    }

    function modalSedang2(a,b){
      $('#optionsedang2').html('<span style="padding: 15px;">Loading...</span>');
      $('#myModalsedang2').css("z-index", b);
      $('#myModalsedang2').modal('toggle');
      formSedang2(a);
    }

    function formSedang2(a) {
      $.get(a, function(data) {
        $('#optionsedang2').html(data);
      });
    }

    function modalBesar(a,b){
      $('#optionbesar').html('<span style="padding: 15px;">Loading...</span>');
      $('#myModalbesar').css("z-index", b);
      $('#myModalbesar').modal('toggle');
      formBesar(a);
    }

    function formBesar(a) {
      $.get(a, function(data) {
        $('#optionbesar').html(data);
      });
    }

    function modalFull(a,b){
      $('#optionfull').html('<span style="padding: 15px;">Loading...</span>');
      $('#myModalfull').css("z-index", b);
      $('#myModalfull').modal('toggle');
      formFull(a);
    }

    function formFull(a) {
      $.get(a, function(data) {
        $('#optionfull').html(data);
      });
    }

    function modalFull2(a,b){
      $('#optionfull2').html('<span style="padding: 15px;">Loading...</span>');
      $('#myModalfull2').css("z-index", b);
      $('#myModalfull2').modal('toggle');
      formFull2(a);
    }

    function formFull2(a) {
      $.get(a, function(data) {
        $('#optionfull2').html(data);
      });
    }

    var BASE_URL = "<?php echo base_url() ?>assets/temp/vendor/tinymce/"; // use your own base url
    tinymce.init({
        selector: ".editoronly textarea",
        theme: "modern",
        // width: 680,
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        // document_base_url: BASE_URL,
        plugins: [
            "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker paste",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "table contextmenu directionality template textcolor responsivefilemanager template"
        ],
        toolbar: "insertfile undo redo | template styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent pagebreak hr | link unlink image media | forecolor backcolor | preview code",
        templates: [
          {title: 'Default', description: 'Default', content: '{{default}}'},
        ],
        image_advtab: true,
        external_filemanager_path: BASE_URL + "filemanager/",
        filemanager_title: "Media",
        external_plugins: { "filemanager": BASE_URL + "filemanager/plugin.min.js" }
    });

    function persentaseKey(key) {
        return (key >= '0' && key <= '9') || key == '-' || key == '.' || key == 'ArrowLeft' || key == 'ArrowRight' || key == 'Delete' || key == 'Backspace' || key == 'Tab' || key == 'F5' || key == 'command';
        // onkeydown="return persentaseKey(event.key)"
    }

    function angkatOnly(key) {
        return (key >= '0' && key <= '9') || key == 'ArrowLeft' || key == 'ArrowRight' || key == 'Delete' || key == 'Backspace' || key == 'Tab' || key == 'F5' || key == 'command';
        // onkeydown="return angkatOnly(event.key)"
    }

    function angkatOnly2(key) {
        return (key >= '0' && key <= '9') || key == 'ArrowLeft' || key == '+' || key == 'ArrowRight' || key == 'Delete' || key == 'Backspace' || key == 'Tab' || key == 'F5' || key == 'command' || key == ' ';
        // onkeydown="return angkatOnly2(event.key)"
    }

    function disabledButton() {
      $('button').addClass('disabled');
      setTimeout(function(){
        $('button').removeClass('disabled');
      }, 3000);
    }

    function showImgfile(objFileInput,tipe = null) {
      if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
          if (tipe==null) {
            $("#targetfileimg").html('<img src="'+e.target.result+'" style="height:110px;border-radius:5px;" />');
          }else{
            $("#targetfileimgedit").html('<img src="'+e.target.result+'" style="height:110px;border-radius:5px;" />');
          }
          //$("#targetfileimg").css('opacity','0.7');
        }
        fileReader.readAsDataURL(objFileInput.files[0]);
      }
    }

    function showImgfile2(objFileInput,tipe = null) {
      if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
          if (tipe==null) {
            $("#targetfileimg2").html('<img src="'+e.target.result+'" style="height:110px;border-radius:5px;" />');
          }else{
            $("#targetfileimgedit2").html('<img src="'+e.target.result+'" style="height:110px;border-radius:5px;" />');
          }
        }
        fileReader.readAsDataURL(objFileInput.files[0]);
      }
    }

    function showImgfileGlobal(objFileInput,tipeid = 'targetfileimg') {
      if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
          $("#"+tipeid).html('<img src="'+e.target.result+'" class="rounded img-fluid" />');
        }
        fileReader.readAsDataURL(objFileInput.files[0]);
      }
    }

    function hapusnoAlertrefresh(a){
      $.get(a, function(result) {
        location.reload();
      });
    }

    // PROSES VIA JQUERY

    function prosesDefault(a,b){
      $.confirm({
        title: 'Confirm!',
        content: 'Kamu yakin ingin melanjutkan?',
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: 'dark',
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('button').addClass('disabled');
            $('#loadingsubmitx').removeClass('d-none');
            var formData = new FormData($("#"+b)[0]);
            $.ajax({
              type: "POST",
              url: '<?=base_url()?>'+a,
              data:  formData,
              contentType: false,
              cache: false,
              processData:false,
              success: function(result){
                $('button').removeClass('disabled');
                var res = result.split('~');
                if (res[0]=='url') {
                  document.body.scrollTop = 0; // For Safari
                  document.documentElement.scrollTop = 0; // Selain Safari
                  document.location=res[1];
                }else if (res[0]=='reload') {
                  document.body.scrollTop = 0;
                  document.documentElement.scrollTop = 0;
                  location.reload();
                }else if (res[0]=='no') {
                  if (res[1]=='default') { res[1] = 'Proses gagal, data gagal diperbarui.'; }
                  confirmGagal(res[1]);
                // khusus point of sale
                }else if (res[0]=='closemodalreload' || res[0]=='poscart' || res[0]=='poscartfinish') {
                  if (res[1]=='default') { res[1] = 'Proses berhasil, data berhasil diperbarui.'; }
                  confirmBerhasil(res[1],res[0],res[2]);
                }else{
                  if (res[1]=='default') { res[1] = 'Proses berhasil, data berhasil diperbarui.'; }
                  confirmBerhasil(res[1]);
                }
              } 
            });
          }
        }
      });
    }

    function prosesHapus(a){
      $.confirm({
        title: 'Confirm!',
        content: 'Kamu yakin ingin menghapus data ini?',
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: 'dark',
        buttons: {
          Cancel: function () {

          },
          Confirm: {
            btnClass: 'btn-danger',
            action: function(){
              $('button').addClass('disabled');
              $.ajax({
                type: "POST",
                url: '<?=base_url()?>'+a,
                data: '',
                contentType: false,
                cache: false,
                processData:false,
                success: function(result){
                  $('button').removeClass('disabled');
                  var res = result.split('~');
                  if (res[0]=='no') {
                    if (res[1]=='default') { res[1] = 'Proses gagal, data gagal dihapus.'; }
                    confirmGagal(res[1],'reload');
                  }else{
                    confirmBerhasil('Proses berhasil, data berhasil dihapus.','closemodalreload');
                  }
                } 
              });
            }
          }
        }
      });
    }

    function prosesActionGDefault(a){
      $.confirm({
        title: 'Confirm!',
        content: 'Kamu yakin ingin melanjutkan?',
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: 'dark',
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('button').addClass('disabled');
            $.get('<?= base_url()?>'+a, function(result) {
              $('button').removeClass('disabled');
              var res = result.split('~');
              if (res[0]=='no') {
                if (res[1]=='default') { res[1] = 'Proses gagal, data gagal diperbarui.'; }
                confirmGagal(res[1]);
              }else{
                confirmBerhasil(res[1],res[0]);
              }
            });
          }
        }
      });
    }

    function prosesActionHapusImg(a){
      $.confirm({
        title: 'Confirm!',
        content: 'Kamu yakin ingin menghapus gambar ini?',
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: 'red',
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('button').addClass('disabled');
            $.get('<?= base_url()?>'+a, function(result) {
              $('button').removeClass('disabled');
              var res = result.split('~');
              if (res[0]=='no') {
                if (res[1]=='default') { res[1] = 'Proses gagal, silahkan coba lagi.'; }
                confirmGagal(res[1]);
              }else{
                confirmBerhasil(res[1],'reload');
              }
            });
          }
        }
      });
    }

    function optionPenarikanDana(a){
      $.confirm({
        title: 'Confirm!',
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: 'dark',
        content: '' +
        '<form id="approvepenarikannid" method="POST" enctype="multipart/form-data">' +
        '<div class="form-group">' +
        '<label>Bukti transfer</label>' +
        '<input type="file" name="gambar" id="gambarbuktitrf" class="gambar form-control" required />' +
        '</div>' +
        '</form>',
        buttons: {
          cancel: function () {
            //close
          },
          formSubmit: {
            text: 'Approved',
            btnClass: 'btn-success',
            action: function () {

              var name = this.$content.find('.gambar').val();
              if(!name){
                $.alert('Gambar tidak boleh kosong.');
                return false;
              }

              var formData = new FormData($("#approvepenarikannid")[0]);
              $.confirm({
                title: 'Confirm!',
                content: 'Data akan dikirim, yakin ingin melanjutkan?',
                theme: 'modern',
                closeIcon: true,
                draggable: false,
                animation: 'scale',
                type: 'dark',
                buttons: {
                  Cancel: function () {
                    optionPenarikanDana(a);
                  },
                  Confirm: function () {
                    $.ajax({
                      type: "POST",
                      url: '<?=base_url('pendapatan/prosesPenarikan/1/')?>'+a,
                      data: formData,
                      contentType: false,
                      cache: false,
                      processData:false,
                      success: function(result){
                        var res = result.split('~');
                        if (res[0]=='no') {
                          confirmGagal(res[1]);
                        }else{
                          confirmBerhasil(res[1],'closemodalreload');
                        }
                      } 
                    });

                  }
                }
              });

            }
          },
        },
        onContentReady: function () {
          // bind to events
          var jc = this;
          this.$content.find('form').on('submit', function (e) {
            // if the user submits the form by pressing enter in the field.
            e.preventDefault();
            jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
        }
      });
    }

    function prosesActionTransaksiTopup(a,b){
      var itype = 'dark'; 
      if (b=='b') {
        itype = 'red'; 
        var icont = 'Kamu yakin ingin membatalkan transaksi ini?';
        var imsg = 'Transaksi telah dibatalkan.';
      }else if (b=='y') {
        var icont = 'Transaksi ini akan diproses, pastikan pembayaran sudah diterima!';
        var imsg = 'Status transaksi selesai.';
      }else{
        var icont = '-';
        var imsg = '-';
      }

      $.confirm({
        title: 'Confirm!',
        content: icont,
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: itype,
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('#loadingtrxdetaction').html('Loading.... &nbsp; '+loadingimg);
            $.get('<?=base_url()?>transaksi/topup_action/'+a+'/'+b, function(result) {
              $('#loadingtrxdetaction').html('');
              if (result=='no') {
                confirmGagal('Proses gagal, silahkan coba lagi.');
              }else{
                confirmBerhasil(imsg,'closemodalreload');
              }
            });
          }
        }
      });
    }

    function prosesActionTransaksiWd(a,b){
      var itype = 'dark'; 
      if (b=='b') {
        itype = 'red'; 
        var icont = 'Kamu yakin ingin menolak penarikan ini?';
        var imsg = 'Penarikan telah ditolak.';
      }else if (b=='y') {
        var icont = 'Penarikan ini akan diproses, pastikan kamu telah men-transfer dan pastikan nonimal serta tujuan penarikan sudah sesuai!';
        var imsg = 'Status penarikan selesai.';
      }else{
        var icont = '-';
        var imsg = '-';
      }

      $.confirm({
        title: 'Confirm!',
        content: icont,
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: itype,
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('#loadingtrxdetaction').html('Loading.... &nbsp; '+loadingimg);
            $.get('<?=base_url()?>transaksi/tariksaldo_action/'+a+'/'+b, function(result) {
              $('#loadingtrxdetaction').html('');
              if (result=='no') {
                confirmGagal('Proses gagal, silahkan coba lagi.');
              }else{
                confirmBerhasil(imsg,'closemodalreload');
              }
            });
          }
        }
      });
    }

    function prosesActionTransaksi(a,b){
      var itype = 'dark'; 
      if (b=='b') {
        itype = 'red'; 
        var icont = 'Kamu yakin ingin membatalkan transaksi ini?';
        var imsg = 'Transaksi telah dibatalkan.';
      }else if (b=='y') {
        var icont = 'Transaksi ini akan diproses, pastikan pesanan segera disiapkan setelah proses ini!';
        var imsg = 'Status transaksi diproses.';
      }else if (b=='k') {
        var icont = 'Status pesanan ini akan berubah menjadi "Sedang Dikirim", pastikan pesanan dikirim sesuai dengan alamat yang dimasukan!';
        var imsg = 'Status transaksi sedang dikirim.';
      }else if (b=='s') {
        var icont = 'Pastikan pesanan sudah diterima oleh "Pembeli" sebelum melanjutkan proses ini!';
        var imsg = 'Status transaksi selesai.';
      }else{
        var icont = '-';
        var imsg = '-';
      }

      $.confirm({
        title: 'Confirm!',
        content: icont,
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: itype,
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('button').addClass('disabled');
            $('#loadingtrxdetaction').html('Loading.... &nbsp; '+loadingimg);
            $.get('<?=base_url()?>transaksi/transaksi_action/'+a+'/'+b, function(result) {
              $('button').removeClass('disabled');
              $('#loadingtrxdetaction').html('');
              if (result=='no') {
                confirmGagal('Proses gagal, silahkan coba lagi.');
              }else{
                if (b=='b' || b=='s') {
                  confirmBerhasil(imsg,'closemodalreload');
                }else{
                  $('#myModalbesar').modal('hide');

                  if (b=='y') {
                    $('#noidtrxidr'+a).html('<span class="badge badge-info">&nbsp;Sedang diproses <i class="fa fa-check"></i>&nbsp;</span>');
                  }else if (b=='k') {
                    $('#noidtrxidr'+a).html('<span class="badge badge-success">&nbsp;Sedang diperjalanan (kurir)&nbsp;</span>');
                  }
                  confirmBerhasil(imsg);
                  setTimeout(function(){
                    modalBesar('<?=base_url('transaksi/transaksiDetail/1900/')?>'+a,'1900');
                  }, 1000);
                }
              }
            });
          }
        }
      });
    }

    function prosesInputResi(a){
      $.confirm({
        title: 'Confirm!',
        content: 'Pastikan nomor resi benar!',
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: 'dark',
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('button').addClass('disabled');
            $.get('<?= base_url()?>'+a, function(result) {
              $('button').removeClass('disabled');
              if (result=='no') {
                confirmGagal('Proses gagal, silahkan coba lagi.');
              }else{
                confirmBerhasil('Nomor resi telah diupdate.');
              }
            });
          }
        }
      });
    }

    function prosessimpanUlasan(a,b){
      $.confirm({
        title: 'Confirm!',
        content: 'Ulasan & Rating akan dipublikasikan!',
        theme: 'modern',
        closeIcon: true,
        draggable: false,
        animation: 'scale',
        type: 'dark',
        buttons: {
          Cancel: function () {

          },
          Confirm: function () {
            $('button').addClass('disabled');
            $.get('<?= base_url()?>'+a, function(result) {
              $('button').removeClass('disabled');
              if (result=='no') {
                confirmGagal('Proses gagal, silahkan coba lagi.');
              }else{
                $('.classclassidbutton'+b).addClass('d-none');
              }
            });
          }
        }
      });
    }

    function confirmBerhasil(a,b = null,c = null){ // yang ada b,c nya action khusus
      $.confirm({
        icon: 'fa fa-check',
        title: 'Successfully',
        content: a,
        theme: 'modern',
        autoClose: 'OK|3000',
        type: 'green',
        draggable: false,
        buttons: {
          OK: function () {
            if (b=='closemodalreload') {
              document.body.scrollTop = 0;
              document.documentElement.scrollTop = 0;
              location.reload();
            }
            // khusus point of sale
            if(b=='poscart'){
              $('#myModalnormal').modal('hide');
              checkCart();
            }
            // khusus point of sale
            if (b=='reload') {
              document.body.scrollTop = 0;
              document.documentElement.scrollTop = 0;
              location.reload();
            }
            if (b=='poscartfinish') {
              $('#myModalnormal').modal('hide');
              checkCart();
              setTimeout(function(){
                modalBesar('<?=base_url('transaksi/transaksiDetail/1900/')?>'+c,'1900');
              }, 500);
            }
          }
        }
      });
    }

    function confirmGagal(a,b = null){
      $.confirm({
        icon: 'fa fa-times',
        title: 'Error',
        content: a,
        theme: 'modern',
        autoClose: 'OK|5000',
        type: 'red',
        draggable: false,
        buttons: {
          OK: function () {
            if (b=='reload') {
              document.body.scrollTop = 0;
              document.documentElement.scrollTop = 0;
              location.reload();
            }
          }
        }
      });
    }

    // khusus point of sale
    function onKeyup(a,b,c = 'y'){
      $('#'+b).html('Loading.... &nbsp; '+loadingimg);
      $.get('<?=base_url()?>'+a, function(data) {
        if (c=='poscart') {
          checkCart();
        }else if (c=='poscartscan') {
          var res = data.split('~');
          if (res[0]=='poscart') {
            confirmBerhasil(res[1]);
            checkCart();
          }else if (res[0]=='opendata') {
            modalNormal(res[1],'1900');
          }else if (res[0]=='no') {
            confirmGagal(res[1]);
          }
        }else{
          $('#'+b).html(data);
        }
      });
    }

    // khusus point of sale
    function checkVoucherPos(a){
      $('#alertresvoucher').html('Loading.... &nbsp; '+loadingimg);
      $.get('<?=base_url()?>'+a, function(data) {
        var res = data.split('~');
        $('#result_pay_cart_isub').html(res[0]);
        $('#result_pay_cart_isubpay').html(res[1]);
        if (res[2]=='y') {
          $('#alertresvoucher').html('');
        }else{
          $('#alertresvoucher').html('<div class="color-danger mt-1">'+res[2]+'</div>');
        }
      });
    }

    // khusus point of sale
    function checkCart(){
      $.get('<?=base_url('pos/loadmyCart')?>', function(data) {
        $('#result_cart_div_user').html(data);
        totalpayCart();
      });
    }

    // khusus point of sale
    function totalpayCart(){
      $.get('<?=base_url('pos/totalpayCart')?>', function(data) {
        var res = data.split('~');
        $('#result_totalpay_div_cart').html(res[0]);
        if (res[1]==0) {
          $('#pay_transaction_div').addClass('disabled-x');
        }else{
          $('#pay_transaction_div').removeClass('disabled-x');
        }
      });
    }

  </script>

</body>

</html>