<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Import_validator Library
 * 
 * Validates product data for bulk imports
 * Handles field validation, category matching, duplicate detection
 */
class Import_validator {

    private $CI;
    private $errors = array();
    private $warnings = array();

    public function __construct() {
        $this->CI = &get_instance();
    }

    /**
     * Validate a complete product row
     * 
     * @param array $row - Product data row
     * @param int $row_number - Row number for reference
     * @return array - ['valid' => bool, 'errors' => array, 'warnings' => array, 'data' => array]
     */
    public function validate_row($row, $row_number) {
        $this->errors = array();
        $this->warnings = array();
        $validated_data = array();

        // Validate required fields
        $required_fields = array('kode_produk', 'nama_produk', 'harga_produk', 'meta_title', 'meta_deskripsi', 'kategori_id', 'potongan_status', 'is_digital');

        foreach ($required_fields as $field) {
            if (!isset($row[$field]) || $row[$field] === null || trim($row[$field]) === '') {
                $this->errors[] = "$field: Field is required";
            }
        }

        // If primary errors, return early
        if (!empty($this->errors)) {
            return array(
                'valid' => false,
                'errors' => $this->errors,
                'warnings' => $this->warnings,
                'data' => $row
            );
        }

        // Validate kode_produk (SKU)
        $validated_data['kode_produk'] = $this->validate_sku($row['kode_produk']);
        if (is_array($validated_data['kode_produk'])) {
            $this->errors = array_merge($this->errors, $validated_data['kode_produk']);
        }

        // Validate nama_produk
        $validated_data['nama_produk'] = $this->validate_string($row['nama_produk'], 75, 'nama_produk');
        if (is_array($validated_data['nama_produk'])) {
            $this->errors = array_merge($this->errors, $validated_data['nama_produk']);
        }

        // Validate harga_produk
        $price_validation = $this->validate_numeric($row['harga_produk'], 0, 999999999, 'harga_produk');
        if (is_array($price_validation)) {
            $this->errors = array_merge($this->errors, $price_validation);
        } else {
            $validated_data['harga_produk'] = $price_validation;
        }

        // Validate meta_title
        $validated_data['meta_title'] = $this->validate_string($row['meta_title'], 150, 'meta_title');
        if (is_array($validated_data['meta_title'])) {
            $this->errors = array_merge($this->errors, $validated_data['meta_title']);
        }

        // Validate meta_deskripsi
        $validated_data['meta_deskripsi'] = htmlspecialchars($row['meta_deskripsi']);

        // Validate potongan_status
        $potongan_validation = $this->validate_enum($row['potongan_status'], array('y', 'n'), 'potongan_status');
        if (is_array($potongan_validation)) {
            $this->errors = array_merge($this->errors, $potongan_validation);
        } else {
            $validated_data['potongan_status'] = $potongan_validation;
        }

        // Validate is_digital
        $digital_validation = $this->validate_enum($row['is_digital'], array('y', 'n'), 'is_digital');
        if (is_array($digital_validation)) {
            $this->errors = array_merge($this->errors, $digital_validation);
        } else {
            $validated_data['is_digital'] = $digital_validation;
        }

        // Conditional: if is_digital='n', require berat_produk and is_new
        if (isset($validated_data['is_digital']) && $validated_data['is_digital'] === 'n') {
            if (!isset($row['berat_produk']) || $row['berat_produk'] === null) {
                $this->errors[] = 'berat_produk: Weight is required for physical products';
            } else {
                $weight_validation = $this->validate_numeric($row['berat_produk'], 0, 999999999, 'berat_produk');
                if (is_array($weight_validation)) {
                    $this->errors = array_merge($this->errors, $weight_validation);
                } else {
                    $validated_data['berat_produk'] = $weight_validation;
                }
            }

            if (!isset($row['is_new']) || $row['is_new'] === null) {
                $this->errors[] = 'is_new: New arrival flag is required for physical products';
            } else {
                $new_validation = $this->validate_enum($row['is_new'], array('y', 'n'), 'is_new');
                if (is_array($new_validation)) {
                    $this->errors = array_merge($this->errors, $new_validation);
                } else {
                    $validated_data['is_new'] = $new_validation;
                }
            }
        } else {
            // Digital products don't need weight/new
            $validated_data['berat_produk'] = 0;
            $validated_data['is_new'] = 'n';
        }

        // Conditional: if potongan_status='y', require discount fields
        if (isset($validated_data['potongan_status']) && $validated_data['potongan_status'] === 'y') {
            if (!isset($row['potongan_diskon']) || $row['potongan_diskon'] === null) {
                $this->errors[] = 'potongan_diskon: Discount amount required when discount enabled';
            } else {
                $discount_validation = $this->validate_numeric($row['potongan_diskon'], 0, $validated_data['harga_produk'], 'potongan_diskon');
                if (is_array($discount_validation)) {
                    $this->errors = array_merge($this->errors, $discount_validation);
                } else {
                    $validated_data['potongan_diskon'] = $discount_validation;
                }
            }

            if (!isset($row['potongan_mulai']) || $row['potongan_mulai'] === null) {
                $this->errors[] = 'potongan_mulai: Discount start date required';
            } else {
                $date_validation = $this->validate_date($row['potongan_mulai'], 'potongan_mulai');
                if (is_array($date_validation)) {
                    $this->errors = array_merge($this->errors, $date_validation);
                } else {
                    $validated_data['potongan_mulai'] = $date_validation;
                }
            }

            if (!isset($row['potongan_akhir']) || $row['potongan_akhir'] === null) {
                $this->errors[] = 'potongan_akhir: Discount end date required';
            } else {
                $date_validation = $this->validate_date($row['potongan_akhir'], 'potongan_akhir');
                if (is_array($date_validation)) {
                    $this->errors = array_merge($this->errors, $date_validation);
                } else {
                    $validated_data['potongan_akhir'] = $date_validation;
                }
            }
        } else {
            $validated_data['potongan_diskon'] = 0;
            $validated_data['potongan_mulai'] = null;
            $validated_data['potongan_akhir'] = null;
        }

        // Validate kategori_id (category mapping)
        if (!isset($row['kategori_id']) || $row['kategori_id'] === null) {
            $this->errors[] = 'kategori_id: At least one category is required';
        } else {
            $cat_result = $this->map_category($row['kategori_id']);
            if ($cat_result === null) {
                $this->errors[] = "kategori_id: Category '{$row['kategori_id']}' not found";
            } else {
                $validated_data['kategori_id'] = $cat_result;
            }
        }

        // Optional fields
        if (isset($row['keterangan_produk']) && $row['keterangan_produk'] !== null) {
            $validated_data['keterangan_produk'] = htmlspecialchars($row['keterangan_produk']);
        } else {
            $validated_data['keterangan_produk'] = '';
        }

        if (isset($row['status_affiliate']) && $row['status_affiliate'] !== null) {
            $aff_validation = $this->validate_enum($row['status_affiliate'], array('d', 'y', 'n'), 'status_affiliate');
            if (!is_array($aff_validation)) {
                $validated_data['status_affiliate'] = $aff_validation;
            }
        } else {
            $validated_data['status_affiliate'] = 'd';
        }

        if (isset($row['komisi_affiliate_produk']) && $row['komisi_affiliate_produk'] !== null) {
            $komisi_validation = $this->validate_numeric($row['komisi_affiliate_produk'], 0, 100, 'komisi_affiliate_produk');
            if (!is_array($komisi_validation)) {
                $validated_data['komisi_affiliate_produk'] = $komisi_validation;
            }
        } else {
            $validated_data['komisi_affiliate_produk'] = 0;
        }

        // Generate URL slug if not exists
        $validated_data['url_produk'] = $this->generate_slug($validated_data['nama_produk']);

        // Return validation result
        return array(
            'valid' => empty($this->errors),
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'data' => $validated_data
        );
    }

    /**
     * Validate SKU field
     * 
     * @param string $sku
     * @return string|array - Validated SKU or array of errors
     */
    private function validate_sku($sku) {
        $sku = trim($sku);

        if (empty($sku)) {
            return array('kode_produk: SKU cannot be empty');
        }

        if (strlen($sku) > 75) {
            return array('kode_produk: SKU cannot exceed 75 characters');
        }

        // Check for duplicate SKU
        $check = $this->CI->db->where('kode_produk', $sku)->where('is_hapus', 'n')->get('m_produk')->row();
        if ($check) {
            return array("kode_produk: SKU '$sku' already exists in system");
        }

        return $sku;
    }

    /**
     * Validate string field
     * 
     * @param string $value
     * @param int $max_length
     * @param string $field_name
     * @return string|array
     */
    private function validate_string($value, $max_length, $field_name) {
        $value = trim($value);

        if (empty($value)) {
            return array("$field_name: Cannot be empty");
        }

        if (strlen($value) > $max_length) {
            return array("$field_name: Cannot exceed $max_length characters");
        }

        return htmlspecialchars($value);
    }

    /**
     * Validate numeric field
     * 
     * @param mixed $value
     * @param float $min
     * @param float $max
     * @param string $field_name
     * @return float|array
     */
    private function validate_numeric($value, $min, $max, $field_name) {
        $value = trim($value);

        if (!is_numeric($value)) {
            return array("$field_name: Must be a number");
        }

        $value = floatval($value);

        if ($value < $min) {
            return array("$field_name: Cannot be less than $min");
        }

        if ($value > $max) {
            return array("$field_name: Cannot exceed $max");
        }

        return $value;
    }

    /**
     * Validate enum field
     * 
     * @param string $value
     * @param array $allowed
     * @param string $field_name
     * @return string|array
     */
    private function validate_enum($value, $allowed, $field_name) {
        $value = trim(strtolower($value));

        if (!in_array($value, $allowed)) {
            $allowed_str = implode(', ', $allowed);
            return array("$field_name: Must be one of: $allowed_str");
        }

        return $value;
    }

    /**
     * Validate date field
     * 
     * @param mixed $value
     * @param string $field_name
     * @return string|array - 'YYYY-MM-DD' format or errors
     */
    private function validate_date($value, $field_name) {
        $value = trim($value);

        // Handle Excel date numbers
        if (is_numeric($value) && $value > 30000 && $value < 60000) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            return $date->format('Y-m-d');
        }

        // Try to parse common date formats
        $formats = array('Y-m-d', 'd-m-Y', 'm/d/Y', 'd/m/Y', 'Y/m/d');
        foreach ($formats as $format) {
            $parsed = \DateTime::createFromFormat($format, $value);
            if ($parsed && $parsed->format($format) === $value) {
                return $parsed->format('Y-m-d');
            }
        }

        return array("$field_name: Invalid date format (use YYYY-MM-DD)");
    }

    /**
     * Map category name to ID (with fuzzy matching)
     * 
     * @param string $category_name
     * @return int|null - Category ID or null
     */
    private function map_category($category_name) {
        $category_name = trim($category_name);

        if (empty($category_name)) {
            return null;
        }

        // Try exact match first
        $exact = $this->CI->db->where('nama_kategori', $category_name)
            ->where('is_hapus', 'n')
            ->where('is_active', 1)
            ->get('m_kategori')
            ->row();

        if ($exact) {
            return $exact->kategori_id;
        }

        // Try case-insensitive match
        $case_insensitive = $this->CI->db->where('LOWER(nama_kategori)', strtolower($category_name))
            ->where('is_hapus', 'n')
            ->where('is_active', 1)
            ->get('m_kategori')
            ->row();

        if ($case_insensitive) {
            return $case_insensitive->kategori_id;
        }

        // Try trimmed match
        $all_categories = $this->CI->db->where('is_hapus', 'n')
            ->where('is_active', 1)
            ->get('m_kategori')
            ->result();

        foreach ($all_categories as $cat) {
            if (trim(strtolower($cat->nama_kategori)) === trim(strtolower($category_name))) {
                return $cat->kategori_id;
            }

            // Fuzzy match using Levenshtein distance
            $normalized_input = strtolower($category_name);
            $normalized_cat = strtolower($cat->nama_kategori);
            $distance = levenshtein($normalized_input, $normalized_cat);
            $max_length = max(strlen($normalized_input), strlen($normalized_cat));
            $similarity = (($max_length - $distance) / $max_length) * 100;

            if ($similarity >= 85) {
                return $cat->kategori_id;
            }
        }

        return null;
    }

    /**
     * Generate URL slug from product name
     * 
     * @param string $name
     * @return string
     */
    private function generate_slug($name) {
        // Simple slug generation
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Limit to 75 chars
        $slug = substr($slug, 0, 75);
        
        return $slug;
    }

    /**
     * Get validation errors
     * 
     * @return array
     */
    public function get_errors() {
        return $this->errors;
    }

    /**
     * Get validation warnings
     * 
     * @return array
     */
    public function get_warnings() {
        return $this->warnings;
    }
}
