<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Kousioner</h4>
            </div>
            <div class="card-body">
                <div class="mt-2 mb-3">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambahBtn"><i class="fa fa-plus"></i> Tambah Data</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="reload_ajax()"><i class="fa fa-sync"></i> Reload</button>
                </div>
                <div class="table-responsive" style="border: 0">
                    <table id="survey" class="w-100 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
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
                <h5 class="modal-title" id="myModalLabel">Tambah Kousioner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('survey/save_survey', array('id' => 'surveyForm'), array('mode' => 'add', 'id' => '')) ?>
                <div class="mb-3">
                    <label class="form-label">Kode</label>
                    <input class="form-control" type="text" name="kode" placeholder="Kode">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input class="form-control" type="text" name="judul" placeholder="Judul">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="8"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input class="form-control" type="date" name="tanggal_mulai">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input class="form-control" type="date" name="tanggal_selesai">
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

<script type="text/javascript">
    var user_id = '<?= $user->id ?>';
</script>