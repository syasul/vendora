<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Produk_import_model
 * 
 * Handles bulk product import business logic
 * Batch insertion, transaction management, report generation
 */
class Produk_import_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Bulk insert validated products
     * Uses batched transactions for performance
     * 
     * @param array $products - Array of validated product data
     * @param int $batch_size - Rows per transaction (default 100)
     * @return array - ['success' => bool, 'imported' => int, 'failed' => array, 'errors' => array]
     */
    public function bulk_insert_products($products, $batch_size = 100) {
        $imported_count = 0;
        $failed_rows = array();
        $errors = array();

        if (empty($products)) {
            return array('success' => false, 'imported' => 0, 'failed' => array(), 'errors' => array('No products to import'));
        }

        // Process in batches
        $batches = array_chunk($products, $batch_size, true);

        foreach ($batches as $batch_index => $batch) {
            $this->db->trans_start();

            try {
                foreach ($batch as $row_number => $product) {
                    $result = $this->insert_single_product($product);

                    if (!$result['success']) {
                        $failed_rows[$row_number] = $result['error'];
                    } else {
                        $imported_count++;
                    }
                }

                // Check for transaction errors
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $errors[] = "Batch " . ($batch_index + 1) . " failed";
                } else {
                    $this->db->trans_complete();
                }

            } catch (Exception $e) {
                $this->db->trans_rollback();
                $errors[] = $e->getMessage();
            }
        }

        return array(
            'success' => empty($errors),
            'imported' => $imported_count,
            'failed' => $failed_rows,
            'errors' => $errors
        );
    }

    /**
     * Insert single product (used in batch operations)
     * 
     * @param array $product - Product data
     * @return array - ['success' => bool, 'product_id' => int, 'error' => string]
     */
    private function insert_single_product($product) {
        try {
            // Generate product ID
            $product_id = $this->get_next_product_id();

            // Prepare product data
            $product_data = array(
                'produk_id'             => $product_id,
                'kode_produk'           => $product['kode_produk'],
                'nama_produk'           => $product['nama_produk'],
                'url_produk'            => $product['url_produk'],
                'harga_produk'          => $product['harga_produk'],
                'berat_produk'          => isset($product['berat_produk']) ? $product['berat_produk'] : 0,
                'keterangan_produk'     => isset($product['keterangan_produk']) ? $product['keterangan_produk'] : '',
                'potongan_status'       => $product['potongan_status'],
                'potongan_diskon'       => isset($product['potongan_diskon']) ? $product['potongan_diskon'] : 0,
                'potongan_mulai'        => isset($product['potongan_mulai']) ? $product['potongan_mulai'] : null,
                'potongan_akhir'        => isset($product['potongan_akhir']) ? $product['potongan_akhir'] : null,
                'is_new'                => isset($product['is_new']) ? $product['is_new'] : 'n',
                'is_digital'            => $product['is_digital'],
                'status_affiliate'      => isset($product['status_affiliate']) ? $product['status_affiliate'] : 'd',
                'komisi_affiliate_produk' => isset($product['komisi_affiliate_produk']) ? $product['komisi_affiliate_produk'] : 0,
                'meta_title'            => $product['meta_title'],
                'meta_deskripsi'        => $product['meta_deskripsi'],
                'is_active'             => 1,
                'file_digital'          => isset($product['file_digital']) ? $product['file_digital'] : '',
                'created_at'            => date('Y-m-d H:i:s')
            );

            // Insert product
            $insert_result = $this->db->insert('m_produk', $product_data);
            if (!$insert_result) {
                return array('success' => false, 'error' => 'Failed to insert product');
            }

            // Insert category
            if (isset($product['kategori_id']) && !empty($product['kategori_id'])) {
                $kategori_data = array(
                    'produk_id'     => $product_id,
                    'kategori_id'   => $product['kategori_id']
                );
                $this->db->insert('m_produk_kategori', $kategori_data);
            }

            // Insert default color if not specified
            if (!isset($product['warna_id']) || empty($product['warna_id'])) {
                $warna_data = array(
                    'produk_id' => $product_id,
                    'warna_id'  => 1
                );
                $this->db->insert('m_produk_warna', $warna_data);
            } else {
                $warna_data = array(
                    'produk_id' => $product_id,
                    'warna_id'  => $product['warna_id']
                );
                $this->db->insert('m_produk_warna', $warna_data);
            }

            // Insert default size if not specified
            if (!isset($product['ukuran_id']) || empty($product['ukuran_id'])) {
                $ukuran_data = array(
                    'produk_id'        => $product_id,
                    'ukuran_id'        => 1,
                    'tambahan_harga'   => 0
                );
                $this->db->insert('m_produk_ukuran', $ukuran_data);
            } else {
                $tambahan = isset($product['harga_tambahan_ukuran']) ? $product['harga_tambahan_ukuran'] : 0;
                $ukuran_data = array(
                    'produk_id'        => $product_id,
                    'ukuran_id'        => $product['ukuran_id'],
                    'tambahan_harga'   => $tambahan
                );
                $this->db->insert('m_produk_ukuran', $ukuran_data);
            }

            return array('success' => true, 'product_id' => $product_id);

        } catch (Exception $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    /**
     * Get next product ID
     * Uses same logic as existing system (urutId helper)
     * 
     * @return int
     */
    private function get_next_product_id() {
        $last = $this->db->order_by('produk_id', 'DESC')->limit(1)->get('m_produk')->row();
        return ($last ? $last->produk_id + 1 : 1);
    }

    /**
     * Check if SKU already exists
     * 
     * @param string $sku
     * @return bool
     */
    public function sku_exists($sku) {
        $check = $this->db->where('kode_produk', $sku)
            ->where('is_hapus', 'n')
            ->get('m_produk')
            ->row();
        return $check ? true : false;
    }

    /**
     * Generate sample Excel data for template
     * 
     * @return array - Sample products
     */
    public function get_template_samples() {
        return array(
            array(
                'kode_produk' => 'SKU001',
                'nama_produk' => 'Contoh Produk 1',
                'harga_produk' => 50000,
                'berat_produk' => 500,
                'kategori_id' => 'Elektronik',
                'meta_title' => 'Contoh Produk 1 - Toko Anda',
                'meta_deskripsi' => 'Deskripsi singkat produk untuk SEO',
                'keterangan_produk' => 'Deskripsi lengkap produk...',
                'potongan_status' => 'n',
                'is_digital' => 'n',
                'is_new' => 'y',
                'status_affiliate' => 'd'
            ),
            array(
                'kode_produk' => 'SKU002',
                'nama_produk' => 'Contoh Produk 2 (dengan diskon)',
                'harga_produk' => 100000,
                'berat_produk' => 1000,
                'kategori_id' => 'Pakaian',
                'meta_title' => 'Contoh Produk 2 - Toko Anda',
                'meta_deskripsi' => 'Produk dengan diskon aktif',
                'potongan_status' => 'y',
                'potongan_diskon' => 15000,
                'potongan_mulai' => '2026-05-07',
                'potongan_akhir' => '2026-05-31',
                'is_digital' => 'n',
                'is_new' => 'n',
                'status_affiliate' => 'd'
            ),
            array(
                'kode_produk' => 'SKU003',
                'nama_produk' => 'Produk Digital',
                'harga_produk' => 25000,
                'kategori_id' => 'Elektronik',
                'meta_title' => 'Produk Digital - Toko Anda',
                'meta_deskripsi' => 'Produk digital tanpa pengiriman',
                'potongan_status' => 'n',
                'is_digital' => 'y',
                'status_affiliate' => 'd'
            )
        );
    }

    /**
     * Get all active categories for reference
     * 
     * @return array
     */
    public function get_categories() {
        return $this->db->where('is_hapus', 'n')
            ->where('is_active', 1)
            ->order_by('nama_kategori', 'ASC')
            ->get('m_kategori')
            ->result_array();
    }

    /**
     * Get import statistics
     * 
     * @return array
     */
    public function get_stats() {
        $total_products = $this->db->where('is_hapus', 'n')->get('m_produk')->num_rows();
        $active_products = $this->db->where('is_hapus', 'n')->where('is_active', 1)->get('m_produk')->num_rows();
        $categories = $this->db->where('is_hapus', 'n')->where('is_active', 1)->get('m_kategori')->num_rows();

        return array(
            'total_products' => $total_products,
            'active_products' => $active_products,
            'categories' => $categories
        );
    }
}
