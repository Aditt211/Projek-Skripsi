<div class="modal fade" id="showLoanModal" tabindex="-1" role="dialog" aria-labelledby="showLoanModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showLoanModalLabel">Detail Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">Peminjam</th>
                                    <td class="show-data" id="show_borrower_name">-</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td class="show-data" id="show_borrower_phone">-</td>
                                </tr>
                                <tr>
                                    <th>Barang</th>
                                    <td class="show-data" id="show_commodity_name">-</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td class="show-data" id="show_quantity">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">Tanggal Pinjam</th>
                                    <td class="show-data" id="show_loan_date">-</td>
                                </tr>
                                <tr>
                                    <th>Batas Waktu</th>
                                    <td class="show-data" id="show_due_date">-</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali</th>
                                    <td class="show-data" id="show_return_date">-</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td class="show-data" id="show_status">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Tujuan Peminjaman</h6>
                        <p class="show-data" id="show_purpose">-</p>
                        <h6>Catatan</h6>
                        <p class="show-data" id="show_notes">-</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>