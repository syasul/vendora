<?php
class NewProductsController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        


        $data = get_defined_vars();
        $this->view('new-products/index', $data);
    }
}
