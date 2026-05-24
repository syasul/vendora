<?php
class CekTransaksiController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 
  
   

  if ($_SESSION['XID_ARRAY'] && $_SESSION['XID_ARRAY']['cust_id']!='guest') {
    header("Location: ".$main_url."account"); exit();
  }




        $data = get_defined_vars();
        $this->view('cek-transaksi/index', $data);
    }
}
