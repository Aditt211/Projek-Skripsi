@extends('layouts.stisla.index', ['title' => 'Admin Dashboard', 'page_heading' => 'Dashboard'])

@section('content')
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-columns"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Barang</h4>
        </div>
        <div class="card-body">
          {{ $commodity_count }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="fas fa-fw fa-check-circle"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Kondisi Baik</h4>
        </div>
        <div class="card-body">
          {{ $commodity_condition_good_count }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-fw fa-exclamation-circle"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Kondisi Rusak Ringan</h4>
        </div>
        <div class="card-body">
          {{ $commodity_condition_not_good_count }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-danger">
        <i class="fas fa-fw fa-times-circle"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Kondisi Rusak Berat</h4>
        </div>
        <div class="card-body">
          {{ $commodity_condition_heavily_damage_count }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Loan Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Peminjaman Aktif</h4>
                </div>
                <div class="card-body">
                    {{ $loans_active }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-check"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Dikembalikan</h4>
                </div>
                <div class="card-body">
                    {{ $loans_returned }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Terlambat</h4>
                </div>
                <div class="card-body">
                    {{ $loans_overdue }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-12 col-md-12 col-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4>Barang Termahal</h4>
      </div>
      <div class="card-body">
        @foreach($commodity_order_by_price as $key => $order_by_price)
        <ul class="list-unstyled list-unstyled-border">
          <li class="media">
            <!-- <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-1.png" alt="avatar"> -->
            <div class="media-body">
              <button data-id="{{ $order_by_price->id }}" class="float-right btn btn-info btn-sm show_modal" data-toggle="modal" data-target="#show_commodity">Detail</button>
              <div class="media-title">{{ $order_by_price->name }}</div>
              <span class="text-small text-muted">Harga: Rp{{ $order_by_price->indonesian_currency($order_by_price->price) }}</span>
            </div>
          </li>
        </ul>
        @endforeach
        <div class="text-center pt-1 pb-1">
          <a href="{{ route('barang.index') }}" class="btn btn-primary btn-lg btn-round">
            Lihat Semua Barang
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Loans Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Peminjaman Terbaru</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Barang</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_loans as $loan)
                            <tr>
                                <td>{{ $loan->borrower_name }}</td>
                                <td>{{ $loan->commodity->name }}</td>
                                <td>{{ $loan->formatted_loan_date }}</td>
                                <td>
                                    @if($loan->status == 'borrowed')
                                        <span class="badge badge-warning">Dipinjam</span>
                                    @elseif($loan->status == 'returned')
                                        <span class="badge badge-success">Dikembalikan</span>
                                    @else
                                        <span class="badge badge-danger">Terlambat</span>
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
</div>
@endsection

@push('modal')
@include('show')
@endpush

@push('js')
@include('_script');
@endpush