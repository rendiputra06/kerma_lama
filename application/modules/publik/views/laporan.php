<div class="card">
    <div class="card-body">
        <div class="mt-2 mb-3">
            <button type="button" class="btn btn-primary waves-effect waves-light" id="tambahBtn"><i class="fa fa-plus"></i> Tambah</button>
            <button type="button" class="btn btn-info waves-effect waves-light" onclick="reload_ajax('penerapan')"><i class="fa fa-sync"></i> Reload</button>
        </div>
        <div class="table-responsive" style="border: 0">
            <table id="penerapan" class="w-100 table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Unit Pelaksana</th>
                        <th>Tanggal</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Unit Pelaksana</th>
                        <th>Tanggal</th>
                        <th>Dokumen</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
<!-- end card -->