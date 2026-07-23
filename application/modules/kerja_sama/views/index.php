<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kerja sama</label>
                        <select class="form-control select2-filter" name="filter_jenis" id="filter_jenis" data-url="kerja_sama/cari_jenis_select2" style="width: 100%;">
                            <option value="">Pilih Jenis Kerja sama</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Unit Pelaksana</label>
                        <select class="form-control select2-filter" name="filter_unit" id="filter_unit" data-url="kerja_sama/cari_unit_select2" style="width: 100%;">
                            <option value="">Pilih Unit Pelaksana</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipe Kerja sama</label>
                        <select class="form-control select2-filter" name="filter_tipe" id="filter_tipe" data-url="kerja_sama/cari_tipe_select2" style="width: 100%;">
                            <option value="">Pilih Tipe Kerja Sama</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Status waktu</label>
                        <select class="form-control select2-filter" name="filter_status" id="filter_status">
                            <option value="">Pilih Status</option>
                            <option value="0">Aktif</option>
                            <option value="1">Akan Berakhir</option>
                            <option value="2">Berakhir</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status kerja sama</label>
                        <select class="form-control select2-filter" name="filter_status_kerma" id="filter_status_kerma">
                            <option value="">Pilih Status</option>
                            <option value="1">Baru</option>
                            <option value="2">Perpanjangan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mt-2 mb-3">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambahBtn"><i class="fa fa-plus"></i> Tambah</button>
                    <button type="button" class="btn btn-success waves-effect waves-light" id="export"><i class="fa fa-excel"></i> Excel</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="reload_ajax('kerma')"><i class="fa fa-sync"></i> Reload</button>
                </div>
                <div class="table-responsive" style="border: 0">
                    <table id="kerma" class="w-100 table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Unit Pelaksana</th>
                                <th>Masa berlaku</th>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
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

    /* .red {
        background-color: red !important;
    } */
</style>
<div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Kerja Sama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('kerja_sama/save', array('id' => 'kermaForm'), array('mode' => 'add', 'id' => '')) ?>
                <div class="mb-3">
                    <label class="form-label">Judul Kerja Sama</label>
                    <input class="form-control" type="text" name="judul" placeholder="Judul">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Referensi</label>
                            <input class="form-control" type="text" name="referensi" placeholder="Referensi">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Kerja Sama</label>
                            <select name="tipe_id" id="tipe" class="form-control select2" data-url="kerja_sama/cari_tipe_select2" style="width: 100%;">
                                <option value="">Pilih Tipe Kerja Sama</option>
                            </select>
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
                            <label class="form-label">Jenis Kerja Sama</label>
                            <select name="jenis_id" id="jenis" class="form-control select2" data-url="kerja_sama/cari_jenis_select2" style="width: 100%;">
                                <option value="">Pilih Jenis Kerja Sama</option>
                            </select>
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
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Mitra</label>
                            <input class="form-control" type="text" name="mitra" placeholder="Mitra">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori Mitra</label>
                            <select name="kategori_id" id="ketegori" class="form-control select2" data-url="kerja_sama/cari_kategori_select2" style="width: 100%;">
                                <option value="">Pilih Kategori Mitra</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bentuk Kerja Sama</label>
                            <select name="bentuk_id" id="bentuk" class="form-control select2" data-url="kerja_sama/cari_bentuk_select2" style="width: 100%;">
                                <option value="">Pilih Bentuk Kerja Sama</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Kerja Sama</label>
                            <select name="status_kerma" id="status_kerma" class="form-control">
                                <option value="1">Baru</option>
                                <option value="2">Perpanjangan</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dokumen</label>
                            <input type="file" id="dokumen" name="dokumen" class="dropify" data-height="150" data-allowed-file-extensions="pdf docx">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <!-- ./row -->
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