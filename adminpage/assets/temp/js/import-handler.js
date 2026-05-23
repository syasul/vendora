/**
 * Import Handler JavaScript
 * Handles Excel file upload, preview, and import processing
 */

let currentPage = 1;
let totalRows = 0;
let validRows = 0;
let invalidRows = 0;
let warningRows = 0;

function downloadTemplate() {
    window.location.href = base_url + 'produk_import/download_template';
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    
    if (!file) {
        document.getElementById('btnUpload').disabled = true;
        return;
    }

    // Validate file type
    if (!file.name.endsWith('.xlsx') && !file.name.endsWith('.xls')) {
        alert('Hanya file Excel (.xlsx) yang diizinkan');
        event.target.value = '';
        document.getElementById('btnUpload').disabled = true;
        return;
    }

    // Validate file size (max 10MB)
    if (file.size > 10485760) {
        alert('Ukuran file tidak boleh melebihi 10MB');
        event.target.value = '';
        document.getElementById('btnUpload').disabled = true;
        return;
    }

    // Update label
    document.querySelector('.custom-file-label').textContent = file.name;
    document.getElementById('btnUpload').disabled = false;
}

function uploadFile() {
    const fileInput = document.getElementById('excelFile');
    const file = fileInput.files[0];

    if (!file) {
        alert('Silakan pilih file terlebih dahulu');
        return;
    }

    const formData = new FormData();
    formData.append('file', file);

    // Show progress
    document.getElementById('uploadProgress').style.display = 'block';
    document.getElementById('uploadStatus').innerHTML = 'Mengunggah file...';
    document.getElementById('uploadStatus').style.display = 'block';
    document.getElementById('btnUpload').disabled = true;

    // Upload file
    $.ajax({
        url: base_url + 'produk_import/upload',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            const data = JSON.parse(response);

            if (data.success) {
                totalRows = data.row_count;
                document.getElementById('totalRows').textContent = totalRows;
                document.getElementById('uploadStatus').className = 'alert alert-success';
                document.getElementById('uploadStatus').innerHTML = `✓ File berhasil diproses: ${totalRows} baris data`;
                
                // Show preview step
                setTimeout(() => {
                    document.getElementById('step1-upload').style.display = 'none';
                    document.getElementById('step2-preview').style.display = 'block';
                    loadPreview(1);
                }, 500);
            } else {
                document.getElementById('uploadStatus').className = 'alert alert-danger';
                document.getElementById('uploadStatus').innerHTML = `✗ Error: ${data.message}`;
            }
        },
        error: function() {
            document.getElementById('uploadStatus').className = 'alert alert-danger';
            document.getElementById('uploadStatus').innerHTML = '✗ Terjadi kesalahan saat mengunggah file';
        },
        complete: function() {
            document.getElementById('uploadProgress').style.display = 'none';
            document.getElementById('btnUpload').disabled = false;
        }
    });
}

function loadPreview(page) {
    currentPage = page;

    $.ajax({
        url: base_url + 'produk_import/get_preview?page=' + page,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                renderPreviewTable(response.rows);
                renderPagination(response.total_pages, page);
                updateStats(response);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat memuat preview');
        }
    });
}

function renderPreviewTable(rows) {
    let html = '';

    if (rows.length === 0) {
        html = '<tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>';
        document.getElementById('previewTableBody').innerHTML = html;
        return;
    }

    validRows = 0;
    invalidRows = 0;
    warningRows = 0;

    rows.forEach(function(row) {
        const status = row.valid ? 'Valid' : 'Invalid';
        const statusClass = row.valid ? 'status-valid' : 'status-invalid';
        const statusBadge = `<span class="status-badge ${statusClass}">${status}</span>`;

        let errorHtml = '';
        if (row.errors.length > 0) {
            errorHtml = '<ul class="error-list mb-0">';
            row.errors.forEach(function(error) {
                errorHtml += `<li>${error}</li>`;
            });
            errorHtml += '</ul>';
        }

        if (row.valid) {
            validRows++;
        } else {
            invalidRows++;
        }

        if (row.warnings.length > 0) {
            warningRows++;
        }

        const sku = row.data.kode_produk || '-';
        const name = row.data.nama_produk || '-';
        const price = row.data.harga_produk || '-';

        html += `
            <tr>
                <td>${row.row_number}</td>
                <td><code>${sku}</code></td>
                <td>${name}</td>
                <td>${price}</td>
                <td>${statusBadge}</td>
                <td>${errorHtml}</td>
            </tr>
        `;
    });

    document.getElementById('previewTableBody').innerHTML = html;
    document.getElementById('validRows').textContent = validRows;
    document.getElementById('invalidRows').textContent = invalidRows;
    document.getElementById('warningRows').textContent = warningRows;
}

function renderPagination(totalPages, currentPage) {
    let html = '';

    // Previous button
    if (currentPage > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadPreview(${currentPage - 1}); return false;">← Previous</a></li>`;
    } else {
        html += '<li class="page-item disabled"><span class="page-link">← Previous</span></li>';
    }

    // Page numbers
    for (let i = 1; i <= Math.min(totalPages, 10); i++) {
        if (i === currentPage) {
            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
        } else {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="loadPreview(${i}); return false;">${i}</a></li>`;
        }
    }

    // Next button
    if (currentPage < totalPages) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadPreview(${currentPage + 1}); return false;">Next →</a></li>`;
    } else {
        html += '<li class="page-item disabled"><span class="page-link">Next →</span></li>';
    }

    document.getElementById('previewPagination').innerHTML = html;
}

function updateStats(response) {
    // Calculate totals based on all pages (estimated)
    const avgPerPage = response.rows.length;
    const estimatedTotal = response.total_rows;
}

function processImport() {
    if (confirm('Anda yakin ingin melakukan import? Proses ini tidak dapat dibatalkan.')) {
        document.getElementById('btnImport').disabled = true;

        $.ajax({
            url: base_url + 'produk_import/process',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                // Hide preview, show results
                document.getElementById('step2-preview').style.display = 'none';
                document.getElementById('step3-results').style.display = 'block';

                if (response.success) {
                    // Show success alert
                    document.getElementById('successAlert').style.display = 'block';
                    document.getElementById('successMessage').textContent = 
                        `${response.imported} produk berhasil diimport ke sistem.`;

                    if (response.failed_count > 0) {
                        document.getElementById('warningAlert').style.display = 'block';
                        document.getElementById('warningMessage').textContent = 
                            `${response.failed_count} baris gagal diimport karena data tidak valid.`;
                    }
                } else {
                    // Show error alert
                    document.getElementById('errorAlert').style.display = 'block';
                    document.getElementById('errorMessage').textContent = response.message;

                    if (response.errors && response.errors.length > 0) {
                        document.getElementById('errorMessage').innerHTML += '<ul>';
                        response.errors.forEach(function(error) {
                            document.getElementById('errorMessage').innerHTML += `<li>${error}</li>`;
                        });
                        document.getElementById('errorMessage').innerHTML += '</ul>';
                    }
                }
            },
            error: function(xhr, status, error) {
                document.getElementById('step2-preview').style.display = 'none';
                document.getElementById('step3-results').style.display = 'block';
                document.getElementById('errorAlert').style.display = 'block';
                document.getElementById('errorMessage').textContent = 'Terjadi kesalahan saat memproses import: ' + error;
            },
            complete: function() {
                document.getElementById('btnImport').disabled = false;
            }
        });
    }
}

function resetUpload() {
    // Reset form
    document.getElementById('excelFile').value = '';
    document.querySelector('.custom-file-label').textContent = 'Pilih file Excel...';
    
    // Reset counters
    totalRows = 0;
    validRows = 0;
    invalidRows = 0;
    warningRows = 0;
    currentPage = 1;

    // Show step 1
    document.getElementById('step1-upload').style.display = 'block';
    document.getElementById('step2-preview').style.display = 'none';
    document.getElementById('step3-results').style.display = 'none';

    // Enable upload button
    document.getElementById('btnUpload').disabled = true;

    // Clear alerts
    document.getElementById('successAlert').style.display = 'none';
    document.getElementById('warningAlert').style.display = 'none';
    document.getElementById('errorAlert').style.display = 'none';
    document.getElementById('uploadStatus').style.display = 'none';
}

// Initialize
$(document).ready(function() {
    document.getElementById('btnUpload').disabled = true;
});
