<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header">
                <span class="card-title h4" id="unitTitle">Tambah Data</span>
                <button type="button" class="btn btn-success waves-effect waves-light float-end" onclick="import_siakad()"><i class="fa fa-upload"></i> Import dari Siakad</button>
            </div>
            <div class="card-body">
                <?= form_open('master/save_unit', array('id' => 'unitForm'), array('id' => '', 'mode' => 'add')) ?>
                <div class="mb-3">
                    <label class="form-label">Nama Unit</label>
                    <input class="form-control" type="text" name="nm_unit" placeholder="Nama">
                    <div class="invalid-feedback"></div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="card-footer">
                <button id="batalBtn" class="btn btn-warning invisible" disabled>Batal</button>
                <button class="btn btn-primary float-end" id="saveBtn">Simpan</button>
            </div>
        </div>
        <!-- .card -->
    </div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <span class="card-title h4">Master Data Unit</span>
                <button type="button" class="btn btn-info waves-effect waves-light float-end" onclick="reload_ajax('unit')"><i class="fa fa-sync"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="border: 0">
                    <table id="unit" class="w-100 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Unit</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nama Unit</th>
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

<div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Program Studi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="border: 0">
                    <table id="sinkron" class="w-100 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Program Studi</th>
                                <th>Jenjang</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Program Studi</th>
                                <th>Jenjang</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" id="saveBtn">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->