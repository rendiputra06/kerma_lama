<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Unit Pelaksana</label>
                <select class="form-control select2-filter" name="filter_unit" id="filter_unit" data-url="publik/cari_unit_select2" style="width: 100%;">
                    <option value="">Pilih Unit Pelaksana</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipe Kerja sama</label>
                <select class="form-control select2-filter" name="filter_tipe" id="filter_tipe" data-url="publik/cari_tipe_select2" style="width: 100%;">
                    <option value="">Pilih Tipe Kerja Sama</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kategori Mitra</label>
                <select class="form-control select2-filter" name="filter_kategori" id="filter_kategori" data-url="publik/cari_kategori_select2" style="width: 100%;">
                    <option value="">Pilih Kategori Mitra</option>
                </select>
            </div>
        </div>
        <div class="mt-2 mb-3">
            <button type="button" class="btn btn-info waves-effect waves-light" onclick="reload_ajax('kerma')"><i class="fa fa-sync"></i> Reload</button>
        </div>
        <div class="table-responsive" style="border: 0">
            <table id="kerma" class="w-100 table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Unit Pelaksana</th>
                        <th>Mitra</th>
                        <th>Masa Berlaku</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Unit Pelaksana</th>
                        <th>Mitra</th>
                        <th>Masa Berlaku</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
<!-- end card -->