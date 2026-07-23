<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Impelementasi Kerja Sama</h4>
            </div>
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
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Unit Pelaksana</th>
                                <th>Tanggal</th>
                                <th>Dokumen</th>
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
    .dropify-wrapper .dropify-message span.file-icon {
        font-size: 20px;
    }

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
                <h5 class="modal-title" id="myModalLabel">Tambah Kerja Sama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('penerapan/save', array('id' => 'penerapanForm'), array('mode' => 'add', 'id' => '')) ?>
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input class="form-control" type="text" name="judul" placeholder="Judul">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Unit Pelaksana</label>
                    <?php if ($this->ion_auth->in_group('prodi')) { ?>
                        <select name="unit_id" id="unit" class="form-control">
                            <option value="<?= $prodi->unit_id ?>" selected><?= $prodi->nm_unit ?></option>
                        </select>
                    <?php } else { ?>
                        <select name="unit_id" id="unit" class="form-control select2" data-url="kerja_sama/cari_unit_select2" style="width: 100%;">
                            <option value="">Pilih Unit Pelaksana</option>
                        </select>
                    <?php } ?>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input class="form-control" type="date" name="tanggal">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dokumen</label>
                    <input type="file" id="dokumen" name="dokumen" class="dropify" data-height="150" data-allowed-file-extensions="pdf docx">
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

<script>
    var id_unit = '<?= $prodi != null ? $prodi->unit_id : ''; ?>';
</script>