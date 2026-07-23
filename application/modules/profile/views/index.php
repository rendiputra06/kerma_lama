<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm order-2 order-sm-1">
                        <div class="d-flex align-items-start mt-3 mt-sm-0">
                            <div class="flex-shrink-0">
                                <div class="avatar-xl me-3">
                                    <img src="<?= base_url() ?>/partial/images/users/<?= $user->img_name ?>" alt="" class="img-fluid rounded-circle d-block">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-16 mb-1"><?= $user->first_name . ' ' . $user->last_name ?></h5>
                                    <p class="text-muted font-size-13"><?= ucwords($group->name) ?></p>

                                    <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                        <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>dibuat : 01 Januari 2021</div>
                                        <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>terakhir login : 01 Januari 2021</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-sm-auto order-1 order-sm-2">
                        <div class="d-flex align-items-start justify-content-end gap-2">
                            <div>
                                <button type="button" class="btn btn-soft-light"><i class="me-1"></i> Message</button>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">Detail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" data-bs-toggle="tab" href="#about" role="tab">Ubah Password</a>
                    </li>
                </ul>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="tab-content">
            <div class="tab-pane active" id="overview" role="tabpanel">
                <div class="row">
                    <div class="col-xl-8 col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <?= form_open('profile/save', array('id' => 'profileForm'), array('mode' => 'edit', 'id' => $user->id)) ?>
                                    <div class="row mb-4">
                                        <label for="first_name" class="col-sm-3 col-form-label">First name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="first_name" value="<?= $user->first_name ?>">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="last_name" class="col-sm-3 col-form-label">Last name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="last_name" value="<?= $user->last_name ?>">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="username" value="<?= $user->username ?>">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" value="<?= $user->email ?>">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="phone" class="col-sm-3 col-form-label">No. Hp</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="phone" value="<?= $user->phone ?>">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary float-end" id="saveBtn" type="button" disabled>Simpan</button>
                                    <?= form_close() ?>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- col -->
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                Foto Profile
                            </div>
                            <div class="card-body">
                                <?= form_open('profile/save_photo', array('id' => 'uploadForm'), array('mode' => 'edit', 'id' => $user->id)) ?>
                                <div class="form-group mb-4">
                                    <input type="file" id="filefoto" name="filefoto" class="dropify" data-height="200" data-default-file="<?= base_url('/partial/images/users/') . $user->img_name ?>">
                                </div>
                                <button class="btn btn-warning mt-2 float-end" type="button" id="uploadBtn" disabled>Simpan</button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end tab pane -->

            <div class="tab-pane" id="about" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <?= form_open('profile/change_password', array('id' => 'passForm'), array('mode' => 'edit', 'id' => $user->id)) ?>
                                <div class="mb-3">
                                    <label class="form-label" for="lama">Password Lama</label>
                                    <input type="password" class="form-control" id="lama" name="passold">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="baru">Password Baru</label>
                                    <input type="password" class="form-control" id="baru" name="passnew">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="konfbaru">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="konfbaru" name="passconf">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <button class="btn btn-success" id="savePassword">Simpan</button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end tab pane -->
        </div>
        <!-- end tab content -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->