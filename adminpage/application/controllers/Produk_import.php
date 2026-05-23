<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Produk_import Controller
 * 
 * Handles bulk product import operations
 * Upload, preview, validation, and import processing
 */
class Produk_import extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_logged_in();
        cek_menu_access();
        
        $this->load->model('auth_model', 'auth');
        $this->load->model('menu_model', 'menu');
        $this->load->model('produk_import_model', 'produk_import');
        $this->load->library('excel_importer');
        $this->load->library('import_validator');
        $this->load->library('form_validation');
    }

    /**
     * Main import page
     */
    public function index() {
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Bulk Import Produk';
        $data['auth'] = $this->auth->getById('m_pengelola', 'pengelola_id', $this->session->userdata('p_id'));
        $data['stats'] = $this->produk_import->get_stats();

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/produk/produk/import', $data);
        $this->load->view('templates/in_footer');
    }

    /**
     * Handle Excel file upload and parsing
     * Returns preview data with validation
     */
    public function upload() {
        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request'));
            return;
        }

        // Check file upload
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
            echo json_encode(array('success' => false, 'message' => 'File upload failed'));
            return;
        }

        $file = $_FILES['file'];

        // Validate file type
        if ($file['type'] !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && 
            $file['type'] !== 'application/vnd.ms-excel') {
            echo json_encode(array('success' => false, 'message' => 'Only XLSX files are allowed'));
            return;
        }

        // Validate file size (max 10MB)
        if ($file['size'] > 10485760) {
            echo json_encode(array('success' => false, 'message' => 'File size cannot exceed 10MB'));
            return;
        }

        // Create temp folder if not exists
        $temp_dir = FCPATH . './../assets/temp/excel_imports/';
        if (!is_dir($temp_dir)) {
            mkdir($temp_dir, 0755, true);
        }

        // Move file to temp location
        $temp_file = $temp_dir . 'import_' . time() . '.xlsx';
        if (!move_uploaded_file($file['tmp_name'], $temp_file)) {
            echo json_encode(array('success' => false, 'message' => 'Failed to save file'));
            return;
        }

        // Parse Excel file
        $load_result = $this->excel_importer->load_file($temp_file);
        if (!$load_result['success']) {
            unlink($temp_file);
            echo json_encode(array('success' => false, 'message' => 'Failed to parse Excel: ' . $load_result['error']));
            return;
        }

        // Map headers
        $header_map = $this->excel_importer->map_headers();

        // Get row count
        $row_count = $this->excel_importer->get_row_count();

        // Store temp file path in session for next steps
        $this->session->set_userdata('import_temp_file', $temp_file);
        $this->session->set_userdata('import_headers', $this->excel_importer->get_headers());
        $this->session->set_userdata('import_header_map', $header_map);
        $this->session->set_userdata('import_row_count', $row_count);

        echo json_encode(array(
            'success' => true,
            'message' => 'File parsed successfully',
            'row_count' => $row_count,
            'headers' => $this->excel_importer->get_headers(),
            'header_map' => $header_map
        ));
    }

    /**
     * Get preview data with validation
     * Paginated to avoid memory issues
     */
    public function get_preview() {
        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request'));
            return;
        }

        $temp_file = $this->session->userdata('import_temp_file');
        if (!$temp_file || !file_exists($temp_file)) {
            echo json_encode(array('success' => false, 'message' => 'Import session expired'));
            return;
        }

        $page = $this->input->get('page', true) ?? 1;
        $per_page = 20;
        $offset = ($page - 1) * $per_page;

        // Reload file
        $this->excel_importer->load_file($temp_file);
        $this->excel_importer->map_headers();

        // Get total rows
        $total_rows = $this->excel_importer->get_row_count();

        // Get paginated rows
        $preview_rows = array();
        $all_rows = $this->excel_importer->get_rows();

        $row_num = 0;
        foreach ($all_rows as $excel_row_num => $row) {
            $row_num++;

            if ($row_num < $offset + 1) continue;
            if ($row_num > $offset + $per_page) break;

            // Validate row
            $validation = $this->import_validator->validate_row($row, $excel_row_num);

            $preview_rows[] = array(
                'row_number' => $excel_row_num,
                'data' => $row,
                'valid' => $validation['valid'],
                'errors' => $validation['errors'],
                'warnings' => $validation['warnings'],
                'validated_data' => $validation['data']
            );
        }

        $total_pages = ceil($total_rows / $per_page);

        echo json_encode(array(
            'success' => true,
            'page' => $page,
            'per_page' => $per_page,
            'total_rows' => $total_rows,
            'total_pages' => $total_pages,
            'rows' => $preview_rows
        ));
    }

    /**
     * Process and import all validated products
     */
    public function process() {
        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request'));
            return;
        }

        $temp_file = $this->session->userdata('import_temp_file');
        if (!$temp_file || !file_exists($temp_file)) {
            echo json_encode(array('success' => false, 'message' => 'Import session expired'));
            return;
        }

        // Reload and parse file
        $this->excel_importer->load_file($temp_file);
        $this->excel_importer->map_headers();

        // Get all rows
        $all_rows = $this->excel_importer->get_rows();

        // Validate all rows
        $valid_products = array();
        $invalid_rows = array();
        $row_num = 0;

        foreach ($all_rows as $excel_row_num => $row) {
            $row_num++;

            // Validate
            $validation = $this->import_validator->validate_row($row, $excel_row_num);

            if ($validation['valid']) {
                $valid_products[$excel_row_num] = $validation['data'];
            } else {
                $invalid_rows[$excel_row_num] = array(
                    'errors' => $validation['errors'],
                    'data' => $row
                );
            }
        }

        // If no valid products, return error
        if (empty($valid_products)) {
            echo json_encode(array(
                'success' => false,
                'message' => 'No valid products to import',
                'invalid_count' => count($invalid_rows)
            ));
            return;
        }

        // Bulk insert
        $import_result = $this->produk_import->bulk_insert_products($valid_products);

        // Clean up temp file
        unlink($temp_file);
        $this->session->unset_userdata('import_temp_file');
        $this->session->unset_userdata('import_headers');
        $this->session->unset_userdata('import_header_map');
        $this->session->unset_userdata('import_row_count');

        // Prepare response
        $response = array(
            'success' => $import_result['success'],
            'imported' => $import_result['imported'],
            'failed_count' => count($invalid_rows),
            'invalid_rows' => $invalid_rows,
            'message' => $import_result['imported'] . ' products imported successfully'
        );

        if (!empty($import_result['errors'])) {
            $response['errors'] = $import_result['errors'];
        }

        // Store failed rows in session for download
        if (!empty($invalid_rows)) {
            $this->session->set_userdata('failed_import_rows', $invalid_rows);
        }

        echo json_encode($response);
    }

    /**
     * Download Excel template
     */
    public function download_template() {
        // Use PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Produk');

        // Set column headers
        $headers = array(
            'kode_produk',
            'nama_produk',
            'harga_produk',
            'berat_produk',
            'kategori_id',
            'meta_title',
            'meta_deskripsi',
            'keterangan_produk',
            'potongan_status',
            'potongan_diskon',
            'potongan_mulai',
            'potongan_akhir',
            'is_digital',
            'is_new',
            'status_affiliate'
        );

        $col = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }

        // Style header row
        $headerStyle = new \PhpOffice\PhpSpreadsheet\Style\Style();
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setRGB('4472C4');
        $headerStyle->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:O1')->applyFromArray($headerStyle->getStyleArray());

        // Add sample data
        $samples = $this->produk_import->get_template_samples();
        $row = 2;
        foreach ($samples as $sample) {
            $col = 1;
            foreach ($headers as $header) {
                $value = isset($sample[$header]) ? $sample[$header] : '';
                $sheet->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
            $row++;
        }

        // Auto-size columns
        for ($col = 1; $col <= count($headers); $col++) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        // Add instructions sheet
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Petunjuk');
        
        $instructions = array(
            array('PETUNJUK IMPOR PRODUK', ''),
            array('', ''),
            array('1. Format File', 'Gunakan format .xlsx (Excel 2007+)'),
            array('2. Baris Header', 'Baris pertama berisi nama kolom (jangan dihapus)'),
            array('3. Field Wajib', 'kode_produk, nama_produk, harga_produk, kategori_id, meta_title, meta_deskripsi, potongan_status, is_digital'),
            array('4. Field Harga', 'Gunakan angka tanpa simbol (contoh: 50000, bukan Rp 50.000)'),
            array('5. Status Y/N', 'Gunakan "y" untuk ya atau "n" untuk tidak'),
            array('6. Kategori', 'Harus sesuai dengan nama kategori yang ada di sistem'),
            array('7. Tanggal', 'Format: YYYY-MM-DD (contoh: 2026-05-07)'),
            array('8. Maksimal Baris', 'Saran 1000-5000 baris per impor untuk performa optimal'),
            array('', ''),
            array('Kategori Aktif:', ''),
        );

        $instr_row = 1;
        foreach ($instructions as $instr) {
            $sheet2->setCellValue('A' . $instr_row, $instr[0]);
            $sheet2->setCellValue('B' . $instr_row, $instr[1]);
            $instr_row++;
        }

        // Add categories
        $categories = $this->produk_import->get_categories();
        foreach ($categories as $cat) {
            $sheet2->setCellValue('A' . $instr_row, $cat['nama_kategori']);
            $instr_row++;
        }

        $sheet2->getColumnDimension('A')->setAutoSize(true);
        $sheet2->getColumnDimension('B')->setAutoSize(true);

        // Output file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Produk_Template_' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    /**
     * Download failed import rows as Excel
     */
    public function download_failed_rows() {
        $failed_rows = $this->session->userdata('failed_import_rows');
        
        if (!$failed_rows || empty($failed_rows)) {
            redirect('produk/produk');
            return;
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Failed Rows');

        // Headers
        $headers = array('Row Number', 'Errors', 'kode_produk', 'nama_produk', 'harga_produk', 'kategori_id');
        $col = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }

        // Data
        $row = 2;
        foreach ($failed_rows as $row_number => $row_data) {
            $sheet->setCellValueByColumnAndRow(1, $row, $row_number);
            $sheet->setCellValueByColumnAndRow(2, $row, implode('; ', $row_data['errors']));
            
            $col = 3;
            foreach ($row_data['data'] as $value) {
                if ($col <= 6) {
                    $sheet->setCellValueByColumnAndRow($col, $row, $value);
                    $col++;
                }
            }
            $row++;
        }

        // Auto-size
        for ($col = 1; $col <= 6; $col++) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Failed_Import_' . date('Y-m-d_His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    /**
     * Reset import session
     */
    public function reset() {
        if (!$this->input->is_ajax_request()) {
            echo json_encode(array('success' => false, 'message' => 'Invalid request'));
            return;
        }

        $temp_file = $this->session->userdata('import_temp_file');
        if ($temp_file && file_exists($temp_file)) {
            unlink($temp_file);
        }

        $this->session->unset_userdata('import_temp_file');
        $this->session->unset_userdata('import_headers');
        $this->session->unset_userdata('import_header_map');
        $this->session->unset_userdata('import_row_count');
        $this->session->unset_userdata('failed_import_rows');

        echo json_encode(array('success' => true));
    }
}
