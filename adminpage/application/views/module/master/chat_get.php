  <style type="text/css">
    .box-c-user {
      display: table; 
      width: 100%;
      margin-bottom: 10px;
      padding-right: 15px;
    }
    .box-cc-user {
      background: #ebebeb;padding: 10px;border-radius: 5px; font-size: 14px; float: right;
    }
    .box-c-anda {
      display: table; 
      margin-bottom: 10px;
    }
    .box-cc-anda {
      background: #efe0ff; padding: 10px;border-radius: 5px; font-size: 14px;
    }
  </style>
  <div class="">
    <div class="padding-0-10" id="scroll_chat" style="overflow-y: scroll; height: calc(100vh - 280px);">
      <?php foreach($get_chat as $obj) { ?>
        <?php if ($obj['admin_id']>0) { ?>
        <div class="box-c-user">
          <div class="box-cc-user">
            <div class="ft-14" style="white-space: pre-line;"><?=$obj['deskripsi'];?></div>
            <div class="text-right ft-12 mt-1"><?=indo($obj['tgl_chat']);?></div>
          </div>
        </div>
        <?php }else{ ?>
        <div class="box-c-anda">
          <div class="box-cc-anda">
            <div class="ft-12 font-weight-bold">User</div>
            <div class="ft-14 text-left" style="white-space: pre-line;"><?=$obj['deskripsi'];?></div>
            <div class="text-right ft-12 mt-1"><?=indo($obj['tgl_chat']);?></div>
          </div>
        </div>
        <?php } ?>
      <?php } ?>
    </div>
    <div class="padding-0-10 pt-3" style="border-top: 1px solid #E1E1E1 !important;">
      <form id="form_live_chat" action="javascript:prosesaddChat()" method="POST">
        <div class="input-group">
          <input type="hidden" class="form-control ft-16" name="idcust" placeholder="isi id cust" value="<?=$idcust;?>">
          <textarea type="text" class="form-control ft-16" name="txt" placeholder="Isi pesan..." required=""></textarea>
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit"><span class="fa fa-paper-plane ml-2 mr-2"></span></button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      document.getElementById('scroll_chat').scrollTop =  document.getElementById('scroll_chat').scrollHeight;

      // setInterval(function(){
      //   onKeyup('master/chat_get/<?=$idcust;?>','txt_isi_chat');
      // }, 60000);

    });

    function prosesaddChat(){
      $('button').addClass('disabled');
      var formData = new FormData($("#form_live_chat")[0]);
      $.ajax({
        type: "POST",
        url: '<?=base_url('master/chat_proses')?>',
        data:  formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(result){
          $('button').removeClass('disabled');
          onKeyup('master/chat_get/<?=$idcust;?>','txt_isi_chat');
        } 
      });
    }
  </script>