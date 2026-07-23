<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Master Data Group</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambahGroup"><i class="fa fa-refresh"></i> Add Group</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="reload_ajax()"><i class="fa fa-refresh"></i> Reload</button>
                </div>
                <div class="table-responsive" style="border: 0">
                    <table id="group" class="w-100 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>description</th>
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
                <h5 class="modal-title" id="myModalLabel">Tambah Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('users/save_group', array('id' => 'groupForm'), array('mode' => 'add')) ?>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control" type="text" name="name" placeholder="Name">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input class="form-control" type="text" name="description" placeholder="Description">
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