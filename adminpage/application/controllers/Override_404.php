<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

	class Override_404 extends CI_Controller  {
	    public function __construct() {
	        parent::__construct(); 
	    } 

	    public function index() { 
	        $this->load->view('module/auth/auth_none');
	    } 
	} 
?>