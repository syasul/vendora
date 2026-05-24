<?php
class ProductCheckoutController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 
  if (!isset($_SESSION['XID_ARRAY'])) { header("Location: ".$main_url); exit(); } 
  if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
    $idnya = $_SESSION['XID_ARRAY']['unique_guest'];
  }else{
    $idnya = $_SESSION['XID_ARRAY']['cust_id'];
  }



        $data = get_defined_vars();
        $this->view('product_checkout/index', $data);
    }
}
