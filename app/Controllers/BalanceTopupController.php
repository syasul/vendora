<?php
class BalanceTopupController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 if (!isset($_SESSION['XID_ARRAY'])) { header("Location: ".$main_url); exit(); }
  $arr = array('tipe' => 'web', 'idtrx' => $_GET['p_url'], 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
  $i_trx = loadData('rest_load/load_riwayat_topup_det/', $arr); $rest_trx = $i_trx['result'];



        $data = get_defined_vars();
        $this->view('balance_topup/index', $data);
    }
}
