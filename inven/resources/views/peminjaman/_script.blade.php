<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    // Modal Create Functions
    function initCreateModal() {
        $('.select2').select2({
            dropdownParent: $('#loan_create_modal .modal-content'),
            width: '100%'
        });
        
        const today = new Date().toISOString().split('T')[0];
        $('input[name="loan_date"]').val(today);
    }

    function resetCreateModal() {
        $('#loan_create_modal form')[0].reset();
        $('.select2').val(null).trigger('change');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $(document.body).css('padding-right', '0');
    }

    // Modal Show Functions
    function loadLoanDetails(id) {
        $.get(`/admin/peminjaman/${id}`, function(response) {
            $('#show_borrower_name').text(response.borrower_name);
            $('#show_borrower_phone').text(response.borrower_phone);
            $('#show_commodity_name').text(response.commodity.name);
            $('#show_quantity').text(response.quantity);
            $('#show_loan_date').text(response.formatted_loan_date);
            $('#show_due_date').text(response.formatted_due_date);
            $('#show_return_date').text(response.return_date ? response.formatted_return_date : '-');
            $('#show_purpose').text(response.purpose);
            $('#show_notes').text(response.notes || '-');
            
            let statusBadge = '';
            switch(response.status) {
                case 'borrowed':
                    statusBadge = '<span class="badge badge-warning">Dipinjam</span>';
                    break;
                case 'returned':
                    statusBadge = '<span class="badge badge-success">Dikembalikan</span>';
                    break;
                default:
                    statusBadge = '<span class="badge badge-danger">Terlambat</span>';
            }
            $('#show_status').html(statusBadge);
        });
    }

    // Return Loan Function
    function returnLoan(id) {
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                        });
                    }
                });
            }
        });
    }

    // Event Listeners
    $('#loan_create_modal').on('shown.bs.modal', initCreateModal);
    $('#loan_create_modal').on('hidden.bs.modal', resetCreateModal);
    
    $(document).on('click', '.show_modal', function() {
        loadLoanDetails($(this).data('id'));
    });
    
    $(document).on('click', '.return-loan', function() {
        returnLoan($(this).data('id'));
    });

    // Form Submit Handler
    $('#loan_create_modal form').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#loan_create_modal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data peminjaman berhasil ditambahkan',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
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

    // Show modal if there are validation errors
    @if($errors->any())
        $('#loan_create_modal').modal('show');
    @endif
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle return loan
    document.querySelectorAll('.return-loan').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
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
                    const token = document.querySelector('meta[name="csrf-token"]').content;
                    
                    fetch(`/admin/peminjaman/${id}/return`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'PATCH'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Barang berhasil dikembalikan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message || 'Terjadi kesalahan saat mengembalikan barang'
                        });
                    });
                }
            });
        });
    });
});
</script>