<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Excel_importer Library
 * 
 * Handles Excel file parsing for bulk product imports
 * Smart header detection and row iteration
 */
class Excel_importer {

    private $CI;
    private $spreadsheet;
    private $worksheet;
    private $headers = array();
    private $header_map = array();

    public function __construct() {
        $this->CI = &get_instance();
    }

    /**
     * Load Excel file and detect headers
     * 
     * @param string $file_path - Full path to XLSX file
     * @return array - ['success' => bool, 'headers' => array, 'error' => string]
     */
    public function load_file($file_path) {
        try {
            if (!file_exists($file_path)) {
                return array('success' => false, 'error' => 'File not found');
            }

            // Load spreadsheet
            $this->spreadsheet = IOFactory::load($file_path);
            $this->worksheet = $this->spreadsheet->getActiveSheet();

            // Get headers from first row
            $headers = array();
            foreach ($this->worksheet->getRowIterator(1, 1) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    $value = $cell->getValue();
                    if ($value !== null) {
                        $headers[] = trim($value);
                    }
                }
                break;
            }

            if (empty($headers)) {
                return array('success' => false, 'error' => 'No headers found in first row');
            }

            $this->headers = $headers;
            return array('success' => true, 'headers' => $headers);

        } catch (Exception $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    /**
     * Map Excel headers to database fields
     * Uses smart fuzzy matching
     * 
     * @param array $field_mapping - Mapping guide ['db_field' => 'excel_column_index']
     * @return array - Normalized header map
     */
    public function map_headers($field_mapping = array()) {
        $header_map = array();

        // Predefined field mappings (Indonesian + English variations)
        $field_aliases = array(
            'kode_produk' => array('kode produk', 'sku', 'kode barang', 'product code', 'produk kode'),
            'nama_produk' => array('nama produk', 'nama barang', 'product name', 'nama', 'barang'),
            'harga_produk' => array('harga', 'harga jual', 'price', 'harga produk', 'harga barang'),
            'berat_produk' => array('berat', 'weight', 'berat barang', 'berat gram'),
            'kategori_id' => array('kategori', 'kategori utama', 'category', 'kategori1', 'cat1'),
            'kategori_sub_id' => array('kategori 2', 'kategori sub', 'subcategory', 'cat2', 'kategori 2'),
            'kategori_sub_lv2_id' => array('kategori 3', 'kategori lv2', 'kategori sub lv2', 'cat3', 'kategori level 2'),
            'meta_title' => array('meta title', 'seo title', 'title', 'judul seo'),
            'meta_deskripsi' => array('meta deskripsi', 'meta description', 'seo deskripsi', 'description'),
            'keterangan_produk' => array('keterangan', 'deskripsi', 'description', 'keterangan produk'),
            'potongan_status' => array('diskon status', 'ada diskon', 'potongan', 'discount', 'potongan status'),
            'potongan_diskon' => array('potongan diskon', 'diskon', 'discount amount', 'nilai diskon'),
            'potongan_mulai' => array('tanggal mulai', 'diskon mulai', 'start date', 'potongan mulai'),
            'potongan_akhir' => array('tanggal akhir', 'diskon akhir', 'end date', 'potongan akhir'),
            'is_digital' => array('produk digital', 'digital', 'is digital', 'digital product'),
            'is_new' => array('produk baru', 'baru', 'new product', 'is new'),
            'status_affiliate' => array('affiliate status', 'status affiliate', 'affiliate'),
            'komisi_affiliate_produk' => array('komisi affiliate', 'komisi', 'affiliate commission'),
            'gambar' => array('gambar', 'gambar 1', 'image', 'image 1', 'foto', 'foto 1'),
            'gambar2' => array('gambar 2', 'image 2', 'foto 2'),
            'gambar3' => array('gambar 3', 'image 3', 'foto 3'),
            'gambar4' => array('gambar 4', 'image 4', 'foto 4'),
            'warna_id' => array('warna', 'color', 'warna produk'),
            'ukuran_id' => array('ukuran', 'size', 'ukuran produk'),
            'harga_tambahan_ukuran' => array('harga tambahan', 'harga ukuran', 'additional price'),
        );

        // Try to map each header to a database field
        foreach ($this->headers as $col_index => $header) {
            $normalized = $this->normalize_string($header);

            // Try to find matching field
            foreach ($field_aliases as $db_field => $aliases) {
                foreach ($aliases as $alias) {
                    $normalized_alias = $this->normalize_string($alias);

                    // Exact match after normalization
                    if ($normalized === $normalized_alias) {
                        $header_map[$col_index] = array(
                            'field' => $db_field,
                            'original_header' => $header,
                            'confidence' => 100
                        );
                        break 2;
                    }

                    // Fuzzy match (Levenshtein distance)
                    $distance = levenshtein($normalized, $normalized_alias);
                    $max_length = max(strlen($normalized), strlen($normalized_alias));
                    $similarity = (($max_length - $distance) / $max_length) * 100;

                    if ($similarity >= 80) {
                        if (!isset($header_map[$col_index]) || $similarity > $header_map[$col_index]['confidence']) {
                            $header_map[$col_index] = array(
                                'field' => $db_field,
                                'original_header' => $header,
                                'confidence' => round($similarity, 2)
                            );
                        }
                    }
                }
            }

            // If no match found, leave unmapped
            if (!isset($header_map[$col_index])) {
                $header_map[$col_index] = array(
                    'field' => null,
                    'original_header' => $header,
                    'confidence' => 0
                );
            }
        }

        $this->header_map = $header_map;
        return $header_map;
    }

    /**
     * Get all rows as array (with headers mapped)
     * Memory efficient - doesn't load entire file
     * 
     * @param int $skip_rows - Rows to skip (default 1 for header)
     * @return array - Array of rows
     */
    public function get_rows($skip_rows = 1) {
        $rows = array();
        $row_count = 0;

        foreach ($this->worksheet->getRowIterator($skip_rows + 1) as $row) {
            $row_count++;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $row_data = array();
            $col_index = 0;

            foreach ($cellIterator as $cell) {
                $value = $cell->getValue();

                // Get mapped field name
                $field = null;
                if (isset($this->header_map[$col_index])) {
                    $field = $this->header_map[$col_index]['field'];
                }

                // Only include mapped columns
                if ($field !== null) {
                    $row_data[$field] = $this->process_cell_value($value);
                }

                $col_index++;
            }

            if (!empty($row_data)) {
                $rows[$row_count] = $row_data;
            }
        }

        return $rows;
    }

    /**
     * Get total row count
     * 
     * @return int
     */
    public function get_row_count() {
        $highest_row = $this->worksheet->getHighestRow();
        return $highest_row - 1; // Subtract header row
    }

    /**
     * Get specific row by number
     * 
     * @param int $row_number - Row number (1-indexed, excluding header)
     * @return array - Row data
     */
    public function get_row($row_number) {
        $actual_row = $row_number + 1; // Adjust for header row
        $row_data = array();

        $row = $this->worksheet->getRowIterator($actual_row, $actual_row);
        foreach ($row as $row_obj) {
            $cellIterator = $row_obj->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $col_index = 0;
            foreach ($cellIterator as $cell) {
                $value = $cell->getValue();

                // Get mapped field name
                if (isset($this->header_map[$col_index])) {
                    $field = $this->header_map[$col_index]['field'];
                    if ($field !== null) {
                        $row_data[$field] = $this->process_cell_value($value);
                    }
                }

                $col_index++;
            }
            break;
        }

        return $row_data;
    }

    /**
     * Process cell value - handle types and encoding
     * 
     * @param mixed $value
     * @return string|null
     */
    private function process_cell_value($value) {
        if ($value === null || $value === '') {
            return null;
        }

        // Handle dates
        if (is_numeric($value) && $value > 30000 && $value < 60000) {
            // Excel timestamp
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            return $date->format('Y-m-d');
        }

        // Trim and encode
        $processed = trim($value);
        $processed = mb_convert_encoding($processed, 'UTF-8', 'UTF-8');
        
        return $processed === '' ? null : $processed;
    }

    /**
     * Normalize string for comparison
     * 
     * @param string $str
     * @return string
     */
    private function normalize_string($str) {
        $str = strtolower($str);
        $str = preg_replace('/[^a-z0-9]/', '', $str);
        return $str;
    }

    /**
     * Close file and cleanup
     */
    public function close() {
        if ($this->spreadsheet) {
            $this->spreadsheet->disconnectWorksheets();
            unset($this->spreadsheet);
        }
    }

    /**
     * Get header map
     * 
     * @return array
     */
    public function get_header_map() {
        return $this->header_map;
    }

    /**
     * Get headers
     * 
     * @return array
     */
    public function get_headers() {
        return $this->headers;
    }
}
