<!-- Modal -->
<div class="modal fade" id="commodity_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="commodity_create" id="commodity_create_form">
          @csrf
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="category">Kategori</label>
                <select class="form-control" id="category" onchange="updateItemCodePrefix()">
                  <option value="">Pilih Kategori</option>
                  <option value="TB">Tataboga</option>
                  <option value="PH">Perhotelan</option>
                  <option value="BS">Busana</option>
                  <option value="MM">Multimedia</option>
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="item_code">Kode Barang</label>
                <input type="text" name="item_code" class="form-control" id="item_code_create" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="acquisition">Asal Perolehan</label>
                <select class="select2-select-dropdown" id="school_operational_assistance_id_create"
                  style="width: 100%;">
                  <option selected>Pilih</option>
                  @foreach($school_operational_assistances as $school_operational_assistance)
                  <option value="{{ $school_operational_assistance->id }}">{{ $school_operational_assistance->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <label for="name">Nama Barang</label>
                <input type="text" class="form-control" id="name_create">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label for="brand">Merek</label>
                <input type="text" class="form-control" id="brand_create">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label for="year_of_purchase">Tahun Pembelian</label>
                <input type="number" class="form-control" id="year_of_purchase_create">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-5">
              <div class="form-group">
                <label for="material">Bahan</label>
                <input type="text" class="form-control" id="material_create">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label for="location">Lokasi</label>
                <select class="select2-select-dropdown" id="commodity_location_id_create" style="width: 100%;">
                  <option selected>Pilih</option>
                  @foreach($commodity_locations as $commodity_location)
                  <option value="{{ $commodity_location->id }}">{{ $commodity_location->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="form-group">
                <label for="condition">Kondisi Barang</label>
                <select class="select2-select-dropdown" id="condition_create" style="width: 100%;">
                  <option selected>Pilih</option>
                  <option value="1">Baik</option>
                  <option value="2">Kurang Baik</option>
                  <option value="3">Rusak Ringan</option>
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <label for="quantity">Kuantitas</label>
                <input type="number" class="form-control" id="quantity_create">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" class="form-control" id="price_create">
              </div>
            </div>

            <div class="col-lg-4">
              <div class="form-group">
                <label for="price_per_item">Harga Satuan</label>
                <input type="number" class="form-control" id="price_per_item_create">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="note">Keterangan</label>
                <textarea class="form-control" id="note_create" rows="3" style="height: 100px;"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="submit_button">Tambah Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function updateItemCodePrefix() {
    var category = document.getElementById('category').value;
    var itemCodeInput = document.getElementById('item_code_create');
    
    if (category) {
      itemCodeInput.value = category + '-' + Math.random().toString(36).substr(2, 8).toUpperCase(); // generates a random code
    } else {
      itemCodeInput.value = ''; // clear if no category is selected
    }
  }

  $(document).ready(function() {
    $('#commodity_create_form').on('submit', function(e) {
      e.preventDefault();
      $('#submit_button').prop('disabled', true);

      // Perform the AJAX request to submit the form data
      $.ajax({
        type: 'POST',
        url: '/commodities', // Adjust the URL as needed
        data: $(this).serialize(),
        success: function(response) {
          // Handle success response
          console.log(response);
          // Clear the form fields
          $('#commodity_create_form')[0].reset();
          $('#submit_button').prop('disabled', false);
          $('#commodity_create_modal').modal('hide');
        },
        error: function(error) {
          // Handle error response
          console.log(error);
          $('#submit_button').prop('disabled', false);
        }
      });
    });
  });
</script>
