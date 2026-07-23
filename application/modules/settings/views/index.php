<div class="card">


    <div class="card-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Pengaturan Umum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">Pengaturan Sistem</span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="home" role="tabpanel">
                <div class="row">
                    <div class="col-xl-6">
                        <?= form_open('settings/save', array('id' => 'settingForm'), array('mode' => 'add')) ?>
                        <div class="mb-3">
                            <label for="system_name" class="form-label">Nama Sistem</label>
                            <!-- <input class="form-control" type="text" id="system_name" name="system_name"> -->
                            <input class="form-control" type="text" value="<?= $general['system_name'] ?>" id="system_name" name="system_name">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="system_title" class="form-label">Title Sistem</label>
                            <!-- <input class="form-control" type="text" id="system_title" name="system_title"> -->
                            <input class="form-control" type="text" value="<?= $general['system_title'] ?>" id="system_title" name="system_title">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="system_email" class="form-label">Default Email</label>
                            <!-- <input class="form-control" type="text" id="system_email" name="system_email"> -->
                            <input class="form-control" type="text" value="<?= $general['system_email'] ?>" id="system_email" name="system_email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <!-- <input class="form-control" type="text" id="address" name="address"> -->
                            <input class="form-control" type="text" value="<?= $general['address'] ?>" id="address" name="address">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button class="btn btn-primary" id="saveBtn" disabled><i class="fa fa-save"></i> Simpan</button>
                        <?= form_close() ?>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                Logo Sistem
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <img class="mx-auto d-block" src="<?= base_url('/partial/images/logo/') . $general['logo'] ?>" alt="" height="100">
                                </div>
                                <?= form_open('settings/save_logo', array('id' => 'uploadForm'), array('mode' => 'edit')) ?>
                                <div class="form-group mb-4">
                                    <input type="file" id="filefoto" name="filefoto" class="dropify" data-height="100" data-default-file="<?= base_url('/partial/images/logo/') . $general['logo'] ?>">
                                </div>
                                <button class="btn btn-warning mt-2 float-end" type="submit" id="uploadBtn" disabled><i class="fa fa-save"></i> Simpan</button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="profile" role="tabpanel">
                <p class="mb-0">
                    -
                </p>
            </div>
        </div>
    </div><!-- end card-body -->
</div><!-- end card -->