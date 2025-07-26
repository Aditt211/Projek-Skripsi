@extends('layouts.stisla.index', ['title' => 'Halaman Data Peminjaman', 'page_heading' => 'Daftar Peminjaman'])

@section('content')
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Data Peminjaman</h4>
            <div class="card-header-action">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createLoanModal">
                    <i class="fas fa-plus"></i> Tambah Peminjaman
                </button>
            </div>
        </div>
        
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>×</span></button>
                    {{ session('success') }}
                </div>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Peminjam</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loan->borrower_name }}</td>
                            <td>{{ $loan->commodity->name }}</td>
                            <td>{{ $loan->quantity }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($loan->status == 'borrowed')
                                    <span class="badge badge-warning">Dipinjam</span>
                                @elseif($loan->status == 'returned')
                                    <span class="badge badge-success">Dikembalikan</span>
                                @else
                                    <span class="badge badge-danger">Terlambat</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info show-loan" data-id="{{ $loan->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($loan->status === 'borrowed')
                                <button type="button" class="btn btn-sm btn-success return-loan" data-id="{{ $loan->id }}">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('peminjaman.modals.create')
@include('peminjaman.modals.show')
@endsection

@push('css')
<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .modal-backdrop { z-index: 1040 !important; }
    .modal-content { z-index: 1100 !important; }
    .select2-container { z-index: 1200 !important; }
    /* Fix modal stacking and backdrop issues */
    .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1040;
        background-color: #000;
    }

    .modal {
        z-index: 1050 !important;
        overflow-y: auto !important;
    }

    .modal-dialog {
        z-index: 1051 !important;
    }

    .select2-container--open {
        z-index: 1052 !important;
    }

    /* Fix body scrolling */
    body.modal-open {
        overflow: hidden;
        padding-right: 0 !important;
    }

    /* Improve modal appearance */
    .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Show modal specific styles */
    .table-bordered th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .form-control-static {
        padding: 0.375rem 0;
        margin-bottom: 0;
        min-height: 2.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    
    #showLoanModal .modal-body {
        padding: 1.5rem;
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }

    .show-data {
        word-break: break-word;
    }
    
    #showLoanModal .table-bordered td {
        padding: 0.75rem;
    }
    
    #showLoanModal h6 {
        margin-top: 1rem;
        font-weight: 600;
    }
    
    #showLoanModal p {
        margin-bottom: 0.5rem;
        padding: 0.5rem 0;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('peminjaman.scripts.modal-handlers')
@endpush