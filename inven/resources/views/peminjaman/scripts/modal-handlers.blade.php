<script>
$(document).ready(function() {
    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize DataTable
    $('#datatable').DataTable();

    // Global modal cleanup function
    window.cleanupModal = function() {
        $('.modal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('body').css('padding-right', '');
        $('.select2').select2('destroy');
    };

    // Handle ESC key
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) { // ESC key
            cleanupModal();
        }
    });

    // Handle modal show event
    $('.modal').on('show.bs.modal', function() {
        cleanupModal(); // Clean up any existing modals
    });

    // Handle modal hidden event
    $('.modal').on('hidden.bs.modal', function() {
        cleanupModal();
    });

    // Initialize Select2
    function initSelect2() {
        $('.select2').select2({
            dropdownParent: $('#createLoanModal'),
            width: '100%'
        }).on('select2:open', function() {
            document.querySelector('.select2-search__field').focus();
        });
    }

    // Create Modal Handlers
    $('#createLoanModal').on('show.bs.modal', function() {
        cleanupModal();
        const today = new Date().toISOString().split('T')[0];
        $('input[name="loan_date"]').val(today);
    });

    $('#createLoanModal').on('shown.bs.modal', function() {
        initSelect2();
    });

    $('#createLoanModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $('.select2').val('').trigger('change');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        cleanupModal();
    });

    // Handle form submission
    $('#createLoanForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#createLoanModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data peminjaman berhasil ditambahkan',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                });
            }
        });
    });

    // Show loan details handler
    $(document).on('click', '.show-loan', function() {
        const id = $(this).data('id');
        
        // Show loading
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Fetch loan details
        $.ajax({
            url: `/admin/peminjaman/${id}`,
            type: 'GET',
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    const data = response.data;
                    
                    // Update modal fields
                    $('#show_borrower_name').text(data.borrower_name);
                    $('#show_borrower_phone').text(data.borrower_phone);
                    $('#show_commodity_name').text(data.commodity.name);
                    $('#show_quantity').text(data.quantity);
                    $('#show_loan_date').text(data.formatted_loan_date);
                    $('#show_due_date').text(data.formatted_due_date);
                    $('#show_return_date').text(data.formatted_return_date || '-');
                    $('#show_purpose').text(data.purpose);
                    $('#show_notes').text(data.notes || '-');

                    // Set status badge
                    const statusBadges = {
                        'borrowed': '<span class="badge badge-warning">Dipinjam</span>',
                        'returned': '<span class="badge badge-success">Dikembalikan</span>',
                        'overdue': '<span class="badge badge-danger">Terlambat</span>'
                    };
                    $('#show_status').html(statusBadges[data.status] || '-');

                    // Show modal
                    $('#showLoanModal').modal({
                        show: true,
                        backdrop: 'static',
                        keyboard: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Terjadi kesalahan saat memuat data'
                    });
                }
            },
            error: function(xhr) {
                console.error('Show loan error:', xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal memuat data peminjaman'
                });
            }
        });
    });

    // Clean up show modal when hidden
    $('#showLoanModal').on('hidden.bs.modal', function() {
        $('.show-data').text('-');
        $('#show_status').html('-');
        
        // Clean up modal artifacts
        setTimeout(() => {
            if (!$('.modal.show').length) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
        }, 200);
    });

    // Return Loan Handler
    $(document).on('click', '.return-loan', function() {
        const id = $(this).data('id');
        const button = $(this);
        
        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: "Apakah Anda yakin ingin mengembalikan barang ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                button.prop('disabled', true);
                
                $.ajax({
                    url: `/admin/peminjaman/${id}/return`,
                    type: 'POST',
                    data: { _method: 'PATCH' },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        button.prop('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                        });
                    }
                });
            }
        });
    });
});
</script>