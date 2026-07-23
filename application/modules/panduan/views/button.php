<div class="row align-items-center">
    <div class="col-md-6">
        <div class="mb-3">
            <h5 class="card-title">Data Panduan Kerja Sama</h5>
        </div>
    </div>

    <div class="col-md-6">
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
            <div>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link <?= $aktif == 'table' ? 'active' : '' ?>" href="<?= site_url('panduan/index') ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="List" data-type="table">
                            <i class="bx bx-list-ul"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $aktif == 'grid' ? 'active' : '' ?>" href="<?= site_url('panduan/index/grid') ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Grid" data-type="grid">
                            <i class="bx bx-grid-alt"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <button id="tambahBtn" class="btn btn-light"><i class="bx bx-plus me-1"></i> Tambah</button>
                <button id="reloadBtn" class="btn btn-warning"><i class="fa fa-sync me-1"></i></button>
            </div>

            <!-- <div class="dropdown">
                <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><button class="dropdown-item" onclick="reload_ajax()">Reload</button></li>
                </ul>
            </div> -->
        </div>

    </div>
</div>
<!-- end row -->

<style>
    .dropify-wrapper .dropify-message span.file-icon {
        font-size: 20px;
    }
</style>
<div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('panduan/save', array('id' => 'panduanForm'), array('mode' => 'add', 'id' => '')) ?>
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input class="form-control" type="text" name="judul" placeholder="Judul">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi Singkat</label>
                    <!-- <input class="form-control" type="text" name="deskripsi" placeholder="Deskripsi Singkat"> -->
                    <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Terbit</label>
                    <input class="form-control" type="date" name="tanggal">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cover</label>
                    <input type="file" id="cover" name="cover" class="dropify" data-height="150" data-allowed-file-extensions="jpg png gif jpeg">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokumen</label>
                    <input type="file" id="dokumen" name="dokumen" class="dropify" data-height="150" data-allowed-file-extensions="pdf docx">
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