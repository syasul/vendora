<?php
class PaymentCallbackController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 
   

  if (isset($_SESSION['trxidunique_xix']) && $_SESSION['trxidunique_xix'] <> '') {
    $trxid = $_SESSION['trxidunique_xix'];
    if ($_GET['p_url']=='success') {
      $t_stpay = 'Transaksi Berhasil';
    }else if ($_GET['p_url']=='pending') {
      $t_stpay = 'Transaksi Berhasil Status Pending';
    }else if ($_GET['p_url']=='unsuccess') {
      $t_stpay = 'Transaksi Gagal Tidak Selesai';
    }else if ($_GET['p_url']=='error') {
      $t_stpay = 'Transaksi Gagal Status Error';
    }else{
      $t_stpay = ' Halaman Tidak Tersedia ';
    }
  }else if ($t_stpay=='error') {
    $t_stpay = ' Transaksi Gagal Status Error ';
  }else{
    $t_stpay = ' Halaman Tidak Tersedia ';
  }



        $data = get_defined_vars();
        $this->view('payment_callback/index', $data);
    }
}
