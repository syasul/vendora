<?php
class NotificationDetailController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 if (!isset($_SESSION['XID_ARRAY'])) { header("Location: ".$main_url); exit(); } 
 
  $arr = array('opsi' => 'i', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'idnotif' => $_GET['p_url'], 'lang' => 'en');
  $val_notif = loadData('rest_load/load_notifikasi/', $arr); $res_n = $val_notif['result'][0];



        $data = get_defined_vars();
        $this->view('notification_detail/index', $data);
    }
}
