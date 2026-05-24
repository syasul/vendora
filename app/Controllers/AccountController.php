<?php
class AccountController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 if (!isset($_SESSION['XID_ARRAY'])) { header("Location: ".$main_url); exit(); } 
 if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']=='guest') { header("Location: ".$main_url); exit(); } 


        $data = get_defined_vars();
        $this->view('account/index', $data);
    }
}
