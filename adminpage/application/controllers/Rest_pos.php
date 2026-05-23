<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Rest_pos extends CI_Controller {

    function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
        header("Content-Type: application/json; charset=utf-8");
        $this->load->model('rest_proses_model', 'restproses');
        $this->load->model('rest_load_model', 'restload');
        $this->load->model('rest_pos_model', 'restpos');
        $this->load->model('produk_model', 'produk');

        require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';
    }

    function index() {
        $config = array(
            'name'      => 'Carvellonic',
            'website'   => 'https://carvellonic.com'
        );
        echo json_encode($config);
    }

    function get_settings() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->get_settings($postjson);
        echo $data;
    }

    function get_data_login() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->get_data_login($postjson);
        echo $data;
    }

    function get_data_products() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->get_data_products($postjson);
        echo $data;
    }

    function get_data_carts() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->get_data_carts($postjson);
        echo $data;
    }

    function get_data_users() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->get_data_users($postjson);
        echo $data;
    }

    function get_data_transaksi() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->get_data_transaksi($postjson);
        echo $data;
    }

    function get_data_transaksi_pday() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->get_data_transaksi_pday($postjson);
        echo $data;
    }

    function proses_signin() {
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->proses_signin($postjson);
        echo $data;
    }

    function proses_transaksi() {
        $mail = new PHPMailer();
        $postjson = json_decode(file_get_contents('php://input'), true);
        $data = $this->restpos->proses_transaksi($postjson, $mail);
        echo $data;
    }

}

?>