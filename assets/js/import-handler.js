/**
 * Import Handler JavaScript
 * Handles bulk product import UI interactions
 */

let currentPage = 1;
let totalPages = 1;
let totalRows = 0;
let validRows = 0;
let invalidRows = 0;
let warningRows = 0;

// Initialize when document ready
$(document).ready(function() {
    // Initialize file input
    bsCustomFileInput.init();

    // Bind events
    $('#excelFile').on('change', handleFileSelect);
});

// Handle file selection
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file type
        const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid Excel file (.xlsx or .xls)');
            resetFileInput();
            return;
        }

        // Validate file size (10MB)
        if (file.size > 10485760) {
            alert('File size cannot exceed 10MB');
            resetFileInput();
            return;
        }

        // Enable upload button
        $('#btnUpload').prop('disabled', false);
        $('#uploadStatus').hide();
    } else {
        $('#btnUpload').prop('disabled', true);
    }
}

// Reset file input
function resetFileInput() {
    $('#excelFile').val('');
    $('#btnUpload').prop('disabled', true);
    bsCustomFileInput.init();
}

// Upload and parse file
function uploadFile() {
    const fileInput = $('#excelFile')[0];
    if (!fileInput.files[0]) {
        alert('Please select a file first');
        return;
    }

    const formData = new FormData();
    formData.append('file', fileInput.files[0]);

    // Show loading
    $('#btnUpload').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>&nbsp; Uploading...');
    $('#uploadProgress').show();
    $('#uploadStatus').removeClass('alert-success alert-danger').addClass('alert-info').html('Uploading and parsing file...').show();

    // Upload file
    $.ajax({
        url: '<?= base_url("produk_import/upload") ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            const xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    $('#uploadProgress .progress-bar').css('width', percentComplete + '%');
                }
            });
            return xhr;
        },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    $('#uploadStatus').removeClass('alert-info').addClass('alert-success').html('File uploaded successfully! Found ' + data.row_count + ' rows.');
                    $('#btnUpload').hide();

                    // Show step 2
                    showStep2(data);
                } else {
                    $('#uploadStatus').removeClass('alert-info').addClass('alert-danger').html('Error: ' + data.message);
                    $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i>&nbsp; Upload & Parse');
                }
            } catch (e) {
                $('#uploadStatus').removeClass('alert-info').addClass('alert-danger').html('Error parsing response');
                $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i>&nbsp; Upload & Parse');
            }
        },
        error: function() {
            $('#uploadStatus').removeClass('alert-info').addClass('alert-danger').html('Upload failed. Please try again.');
            $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i>&nbsp; Upload & Parse');
        }
    });
}

// Show step 2 (preview)
function showStep2(data) {
    $('#step1-upload').hide();
    $('#step2-preview').show();

    totalRows = data.row_count;
    $('#totalRows').text(totalRows);

    // Load first page of preview
    loadPreview(1);
}

// Load preview data
function loadPreview(page) {
    $('#previewTableBody').html('<tr><td colspan="6" class="text-center"><i class="fa fa-spinner fa-spin"></i>&nbsp; Loading...</td></tr>');

    $.ajax({
        url: '<?= base_url("produk_import/get_preview") ?>',
        type: 'GET',
        data: { page: page },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data.success) {
                    currentPage = data.page;
                    totalPages = data.total_pages;
                    displayPreview(data.rows);

                    // Update pagination
                    updatePagination(data.page, data.total_pages);
                } else {
                    $('#previewTableBody').html('<tr><td colspan="6" class="text-center text-danger">Error: ' + data.message + '</td></tr>');
                }
            } catch (e) {
                $('#previewTableBody').html('<tr><td colspan="6" class="text-center text-danger">Error loading preview</td></tr>');
            }
        },
        error: function() {
            $('#previewTableBody').html('<tr><td colspan="6" class="text-center text-danger">Failed to load preview</td></tr>');
        }
    });
}

// Display preview rows
function displayPreview(rows) {
    let html = '';
    validRows = 0;
    invalidRows = 0;
    warningRows = 0;

    if (rows.length === 0) {
        html = '<tr><td colspan="6" class="text-center text-muted">No data found</td></tr>';
    } else {
        rows.forEach(function(row) {
            let statusClass = 'table-success';
            let statusText = 'Valid';
            let errorsText = '';

            if (!row.valid) {
                statusClass = 'table-danger';
                statusText = 'Invalid';
                errorsText = row.errors.join('; ');
                invalidRows++;
            } else {
                validRows++;
                if (row.warnings.length > 0) {
                    statusClass = 'table-warning';
                    statusText = 'Warning';
                    errorsText = row.warnings.join('; ');
                    warningRows++;
                }
            }

            html += `
                <tr class="${statusClass}">
                    <td>${row.row_number}</td>
                    <td>${row.data.kode_produk || ''}</td>
                    <td>${row.data.nama_produk || ''}</td>
                    <td>${row.data.harga_produk || ''}</td>
                    <td><span class="badge badge-${row.valid ? (row.warnings.length > 0 ? 'warning' : 'success') : 'danger'}">${statusText}</span></td>
                    <td class="text-danger">${errorsText}</td>
                </tr>
            `;
        });
    }

    $('#previewTableBody').html(html);

    // Update counters
    $('#validRows').text(validRows);
    $('#invalidRows').text(invalidRows);
    $('#warningRows').text(warningRows);
}

// Update pagination
function updatePagination(current, total) {
    let html = '';

    if (total > 1) {
        // Previous button
        html += `<li class="page-item ${current == 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadPreview(${current - 1})">Previous</a>
        </li>`;

        // Page numbers
        for (let i = 1; i <= total; i++) {
            if (i === current || (i >= current - 2 && i <= current + 2) || i === 1 || i === total) {
                html += `<li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadPreview(${i})">${i}</a>
                </li>`;
            } else if (i === current - 3 || i === current + 3) {
                html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Next button
        html += `<li class="page-item ${current == total ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadPreview(${current + 1})">Next</a>
        </li>`;
    }

    $('#previewPagination').html(html);
}

// Process import
function processImport() {
    if (validRows === 0) {
        alert('No valid products to import');
        return;
    }

    if (!confirm(`Import ${validRows} valid products? Invalid rows will be skipped.`)) {
        return;
    }

    $('#btnImport').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>&nbsp; Importing...');

    $.ajax({
        url: '<?= base_url("produk_import/process") ?>',
        type: 'POST',
        success: function(response) {
            try {
                const data = JSON.parse(response);
                showResults(data);
            } catch (e) {
                alert('Error processing import');
                $('#btnImport').prop('disabled', false).html('<i class="fa fa-check"></i>&nbsp; Lanjutkan Import');
            }
        },
        error: function() {
            alert('Import failed. Please try again.');
            $('#btnImport').prop('disabled', false).html('<i class="fa fa-check"></i>&nbsp; Lanjutkan Import');
        }
    });
}

// Show import results
function showResults(data) {
    $('#step2-preview').hide();
    $('#step3-results').show();

    if (data.success) {
        $('#successAlert').show();
        $('#successMessage').text(data.message);

        if (data.failed_count > 0) {
            $('#warningAlert').show();
            $('#warningMessage').text(`${data.failed_count} rows failed to import. You can download the failed rows for review.`);
            $('#btnDownloadFailed').attr('href', '<?= base_url("produk_import/download_failed_rows") ?>');
        } else {
            $('#warningAlert').hide();
        }

        $('#errorAlert').hide();
    } else {
        $('#successAlert').hide();
        $('#warningAlert').hide();
        $('#errorAlert').show();
        $('#errorMessage').text(data.message || 'Import failed');
    }
}

// Reset upload
function resetUpload() {
    // Reset file input
    resetFileInput();

    // Reset UI
    $('#step1-upload').show();
    $('#step2-preview').hide();
    $('#step3-results').hide();

    $('#uploadProgress').hide();
    $('#uploadStatus').hide();
    $('#btnUpload').show().prop('disabled', true).html('<i class="fa fa-upload"></i>&nbsp; Upload & Parse');

    // Clear preview
    $('#previewTableBody').html('<tr><td colspan="6" class="text-center text-muted">Loading...</td></tr>');
    $('#previewPagination').html('');

    // Reset counters
    $('#totalRows, #validRows, #invalidRows, #warningRows').text('0');

    // Clear session data
    $.ajax({
        url: '<?= base_url("produk_import/reset") ?>',
        type: 'POST'
    });
}

// Download template
function downloadTemplate() {
    window.location.href = '<?= base_url("produk_import/download_template") ?>';
}