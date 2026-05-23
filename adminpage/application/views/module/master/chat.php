<style>
  .user-chat-list {
    padding: 10px;
    border-radius: 5px;
  }
  .user-chat-list:hover {
    cursor: pointer;
    background: #e4e4e4;
  }
</style>
<div class="container-fluid" id="container-wrapper">
  <div class="row mb-3">
    <div class="col-xl-4 col-lg-5">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white">Users Chat</h6>
        </div>
        <div class="p-3" style="overflow-y: auto; max-height: calc(50vh);">
          <?php $no=1; foreach ($user_chat as $data) { ?>
          <div class="user-chat-list" onclick="onKeyup('master/chat_get/<?=$data['cust_id'];?>','txt_isi_chat')">
            <?=$data['cust_nama'];?>
            <?php if ($data['chatbaru']>0) { ?>
              <span class="badge badge-danger float-right">baru</span>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="col-xl-8 col-lg-7">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
        </div>
        <div class="p-3">
          <div id="txt_isi_chat">Pilih user untuk melihat chat...</div>
        </div>
      </div>
    </div>
  </div>
</div>