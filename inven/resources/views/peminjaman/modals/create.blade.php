<div class="modal fade" id="createLoanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createLoanForm" action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Barang <span class="text-danger">*</span></label>
                                <select name="commodity_id" class="form-control select2" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($commodities as $commodity)
                                    <option value="{{ $commodity->id }}">{{ $commodity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Peminjam <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="borrower_name" required>
                            </div>
                            <div class="form-group">
                                <label>No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="borrower_phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="quantity" min="1" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Pinjam <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="loan_date" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Kembali <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="due_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tujuan Peminjaman <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="purpose" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
