<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Master Data Pengguna</h4>
            </div>
            <div class="card-body">
                <div class="mt-2 mb-3">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambahUser"><i class="fa fa-plus"></i> Tambah Pengguna</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="reload_ajax()"><i class="fa fa-sync"></i> Reload</button>
                    <div class="float-end">
                        <label for="show_me">
                            <input type="checkbox" id="show_me">
                            Tampilkan saya
                        </label>
                    </div>
                </div>
                <div class="table-responsive" style="border: 0">
                    <table id="users" class="w-100 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th class="text-center">Status</th>
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
                <h5 class="modal-title" id="myModalLabel">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('users/save', array('id' => 'userForm'), array('mode' => 'add')) ?>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Username">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input class="form-control" type="text" name="full_name" placeholder="Nama Lengkap">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="text" name="email" placeholder="Email">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Level</label>
                    <select name="level[]" id="level" class="form-control select2" data-url="users/cari_level_select2" style="width: 100%;" multiple="multiple">
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="row">
                        <div class="col-6">
                            <input class="form-check-input" type="radio" name="status" id="user_active" value="1" checked>
                            <label class="form-check-label" for="user_active">
                                Active
                            </label>
                        </div>
                        <div class="col-6">
                            <input class="form-check-input" type="radio" name="status" id="user_deactive" value="0">
                            <label class="form-check-label" for="user_deactive">
                                Deactive
                            </label>
                        </div>
                    </div>
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