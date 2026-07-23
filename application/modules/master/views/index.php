<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header">
                <span class="card-title h4" id="jenisTitle">Tambah Data</span>
            </div>
            <div class="card-body">
                <?= form_open('master/save_jenis', array('id' => 'jenisForm'), array('id' => '', 'mode' => 'add')) ?>
                <div class="mb-3">
                    <label class="form-label">Nama Jenis</label>
                    <input class="form-control" type="text" name="nama" placeholder="Nama">
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
                <span class="card-title h4">Master Data Jenis Mitra</span>
                <button type="button" class="btn btn-info waves-effect waves-light float-end" onclick="reload_ajax('jenis')"><i class="fa fa-sync"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="border: 0">
                    <table id="jenis" class="w-100 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
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