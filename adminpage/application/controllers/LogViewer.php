<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogViewer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //is_logged_in();
    }

    public function index() {
        if(isset($_GET['cg'])=='log'){
            // Path log files di folder application/logs/
            $log_directory = APPPATH . 'logs/';
            $log_files = array_diff(scandir($log_directory), array('.', '..', 'index.html'));

            // Urutkan log berdasarkan tanggal file terbaru
            usort($log_files, function($a, $b) use ($log_directory) {
                return filemtime($log_directory . $b) - filemtime($log_directory . $a);
            });

            // Ambil hanya 3 file terbaru
            $log_files = array_slice($log_files, 0, 3);

            // Load isi file log
            $log_contents = [];
            foreach ($log_files as $log_file) {
                $path = $log_directory . $log_file;
                if (is_readable($path)) {
                    $log_contents[$log_file] = file_get_contents($path);
                }
            }

            // Tampilkan di view
            $this->load->view('log_viewer', ['log_contents' => $log_contents]);
        }
    }
}
