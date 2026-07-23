<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Tendik</h4>
            </div>
            <div class="card-body">
                <div class="mt-2 mb-3">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambahBtn"><i class="fa fa-plus"></i> Tambah</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="reload_ajax('tendik')"><i class="fa fa-sync"></i> Reload</button>
                </div>
                <div class="table-responsive" style="border: 0">
                    <table id="tendik" class="w-100 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Program Studi</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Program Studi</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div> <!-- end row -->
<style>
    .select2-container--default .select2-selection--single {
        padding: 6px;
        height: 37px;
        font-size: 1em;
    }

    .is-invalid .select2-container--default .select2-selection--single {
        border-color: rgb(185, 74, 72) !important;
    }
</style>
<div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Data Tendik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('master/save_tendik', array('id' => 'tendikForm'), array('mode' => 'add', 'id' => '')) ?>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input class="form-control" type="text" name="nama" placeholder="nama">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="text" name="email" placeholder="email">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Program Studi</label>
                    <select name="unit_id" id="unit" class="form-control select2" data-url="penerapan/cari_unit_select2" style="width: 100%;">
                        <option value="">Pilih Program Studi</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" id="saveBtn">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->