<div class="container-fluid" id="container-wrapper">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                    <div class="text-right">
                        <a href="<?= base_url('produk/produk/')?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                        <button type="button" class="btn btn-success btn-sm" id="btnDownloadTemplate" onclick="downloadTemplate()"><i class="fa fa-download"></i>&nbsp; Download Template</button>
                    </div>
                </div>
                <div class="card-body">
                    <?= $this->session->flashdata('message'); ?>

                    <!-- Step 1: File Upload -->
                    <div id="step1-upload" class="step-container">
                        <div class="form-group">
                            <label for="excelFile" class="font-weight-bold">Step 1: Upload File Excel</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excelFile" accept=".xlsx,.xls" onchange="handleFileSelect(event)">
                                <label class="custom-file-label" for="excelFile">Pilih file Excel...</label>
                            </div>
                            <small class="form-text text-muted">
                                Format: .xlsx (Excel 2007+) | Maksimal: 10MB | Rekomendasi: 1000-5000 baris per file
                            </small>
                        </div>

                        <div id="uploadProgress" class="progress" style="display: none;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                        </div>

                        <div id="uploadStatus" class="alert alert-info" style="display: none;"></div>

                        <button type="button" class="btn btn-primary" id="btnUpload" disabled onclick="uploadFile()">
                            <i class="fa fa-upload"></i>&nbsp; Upload & Parse
                        </button>
                    </div>

                    <!-- Step 2: Preview & Validation -->
                    <div id="step2-preview" class="step-container" style="display: none; margin-top: 30px;">
                        <h5 class="font-weight-bold">Step 2: Preview & Validasi</h5>
                        <hr>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="card border-left-primary">
                                    <div class="card-body">
                                        <span class="font-weight-bold">Total Baris</span>
                                        <div class="h3" id="totalRows">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-left-success">
                                    <div class="card-body">
                                        <span class="font-weight-bold">Valid</span>
                                        <div class="h3" id="validRows">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-left-danger">
                                    <div class="card-body">
                                        <span class="font-weight-bold">Invalid</span>
                                        <div class="h3" id="invalidRows">0</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-left-info">
                                    <div class="card-body">
                                        <span class="font-weight-bold">Warnings</span>
                                        <div class="h3" id="warningRows">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-hover" id="previewTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">Row</th>
                                        <th width="15%">SKU</th>
                                        <th width="30%">Nama Produk</th>
                                        <th width="15%">Harga</th>
                                        <th width="15%">Status</th>
                                        <th width="20%">Errors</th>
                                    </tr>
                                </thead>
                                <tbody id="previewTableBody">
                                    <tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <nav>
                            <ul class="pagination justify-content-center" id="previewPagination">
                            </ul>
                        </nav>

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" onclick="resetUpload()">
                                <i class="fa fa-redo"></i>&nbsp; Upload Ulang
                            </button>
                            <button type="button" class="btn btn-success" id="btnImport" onclick="processImport()">
                                <i class="fa fa-check"></i>&nbsp; Lanjutkan Import
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Import Results -->
                    <div id="step3-results" class="step-container" style="display: none; margin-top: 30px;">
                        <h5 class="font-weight-bold">Step 3: Hasil Import</h5>
                        <hr>

                        <div class="alert alert-success" id="successAlert" style="display: none;">
                            <h4 class="alert-heading">Import Berhasil!</h4>
                            <p id="successMessage"></p>
                        </div>

                        <div class="alert alert-warning" id="warningAlert" style="display: none;">
                            <h4 class="alert-heading">Import Selesai dengan Catatan</h4>
                            <p id="warningMessage"></p>
                            <hr>
                            <a href="#" class="btn btn-sm btn-warning" id="btnDownloadFailed">
                                <i class="fa fa-download"></i>&nbsp; Download Baris Gagal
                            </a>
                        </div>

                        <div class="alert alert-danger" id="errorAlert" style="display: none;">
                            <h4 class="alert-heading">Import Gagal</h4>
                            <p id="errorMessage"></p>
                        </div>

                        <div class="mt-3">
                            <a href="<?= base_url('produk/produk/') ?>" class="btn btn-primary">
                                <i class="fa fa-check"></i>&nbsp; Lihat Produk
                            </a>
                            <button type="button" class="btn btn-secondary" onclick="resetUpload()">
                                <i class="fa fa-redo"></i>&nbsp; Import Lagi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title font-weight-bold">Total Produk</h6>
                    <div class="h3"><?= $stats['total_products']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title font-weight-bold">Produk Aktif</h6>
                    <div class="h3"><?= $stats['active_products']; ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title font-weight-bold">Kategori</h6>
                    <div class="h3"><?= $stats['categories']; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const importUrls = {
        upload: '<?= base_url("produk_import/upload") ?>',
        get_preview: '<?= base_url("produk_import/get_preview") ?>',
        process: '<?= base_url("produk_import/process") ?>',
        reset: '<?= base_url("produk_import/reset") ?>',
        download_failed_rows: '<?= base_url("produk_import/download_failed_rows") ?>',
        download_template: '<?= base_url("produk_import/download_template") ?>'
    };
</script>
<script src="<?= base_url('assets/js/import-handler.js'); ?>"></script>

<style>
    .step-container {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .status-badge {
        padding: 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.85rem;
    }

    .status-valid {
        background-color: #d4edda;
        color: #155724;
    }

    .status-invalid {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .error-list {
        font-size: 0.85rem;
        color: #721c24;
    }

    .error-list li {
        margin-bottom: 0.25rem;
    }

    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
</style>
