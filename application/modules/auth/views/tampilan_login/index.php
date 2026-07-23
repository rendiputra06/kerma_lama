<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="index.php" class="d-block auth-logo">
                                    <img src="<?= base_url('partial/images/logo/') . $this->config->item('logo'); ?>" alt="" height="28"> <span class="logo-txt"><span class="logo-txt"><?= $this->config->item('system_name'); ?></span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Selamat Datang !</h5>
                                    <p class="text-muted mt-2">Silahkan login untuk melanjutkan</p>

                                </div>
                                <?= form_open("auth/cek_login", array('class' => 'custom-form mt-4 pt-2', 'id' => 'login')); ?>
                                <div id="infoMessage" class="text-center alert-dismissible"><?php echo $message; ?></div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Username</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <?= form_input($identity); ?>
                                        <button class="btn btn-light ms-0" type="button"><i class="mdi mdi-account"></i></button>
                                        <div class="invalid-tooltip">username salah</div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Password</label>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="">
                                                <a href="auth-recoverpw.php" class="text-muted">Forgot password?</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group auth-pass-inputgroup">
                                        <?= form_input($password); ?>
                                        <button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        <div class="invalid-tooltip">password salah</div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-check">
                                            <?= form_checkbox('remember', '', FALSE, 'id="remember"'); ?>
                                            <label class="form-check-label" for="remember-check">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-8">
                                        <div class="checkbox icheck">
                                            <label>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3">
                                    <?= form_submit('submit', 'Log In', array('id' => 'submit', 'class' => 'btn btn-primary w-100 waves-effect waves-light')); ?>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>
                                        document.write(new Date().getFullYear())
                                    </script> <i class="mdi mdi-heart text-danger"></i> by Universitas Abdurrab</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-primary"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-7">
                            <div class="p-0 p-sm-4 px-xl-0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>
<script type="text/javascript">
    let base_url = '<?= base_url(); ?>';

    // login with button
    // $('.login').on('click', function() {
    // 	$('#login input[name="identity"]').val($(this).data('user'));
    // 	$('#login input[name="password"]').val($(this).data('password'));
    // 	$('#login').submit();
    // });
</script>
<script src="<?= base_url() ?>partial/js/halaman/login.js"></script>