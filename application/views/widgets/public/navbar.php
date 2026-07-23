<div class="navbar-header">
    <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="index.php" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= base_url('partial/images/logo/') . $this->config->item('logo'); ?>" alt="" height="24">
                </span>
                <span class="logo-lg">
                    <img src="<?= base_url('partial/images/logo/') . $this->config->item('logo'); ?>" alt="" height="24"> <span class="logo-txt"><?= $this->config->item('system_name'); ?></span>
                </span>
            </a>

            <a href="index.php" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= base_url('partial/images/logo/') . $this->config->item('logo'); ?>" alt="" height="24">
                </span>
                <span class="logo-lg">
                    <img src="<?= base_url('partial/images/logo/') . $this->config->item('logo'); ?>" alt="" height="24"> <span class="logo-txt"><?= $this->config->item('system_name'); ?></span>
                </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <i class="fa fa-fw fa-bars"></i>
        </button>

        <!-- App Search-->
        <!-- <form class="app-search d-none d-lg-block">
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Search">
                <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
            </div>
        </form> -->
    </div>

    <div class="d-flex">

        <div class="dropdown d-inline-block d-lg-none ms-2">
            <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="search" class="icon-lg"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                <form class="p-3">
                    <div class="form-group m-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" aria-label="Search Result">

                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="dropdown d-none d-sm-inline-block">
            <button type="button" class="btn header-item" id="mode-setting-btn">
                <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                <i data-feather="sun" class="icon-lg layout-mode-light"></i>
            </button>
        </div>
        <a class="btn mt-3" href="<?= site_url('dashboard')?>">
                <i data-feather="grid" class="icon-lg"></i>
        </a>
        <!--<div class="dropdown d-none d-lg-inline-block ms-1">-->
        <!--    <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
        <!--        <i data-feather="grid" class="icon-lg"></i>-->
        <!--    </button>-->
        <!--    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">-->
        <!--        <div class="p-2">-->
        <!--            <div class="row g-0">-->
        <!--                <div class="col">-->
        <!--                    <a class="dropdown-icon-item" href="#">-->
        <!--                        <img src="<?= base_url() ?>partial/images/brands/github.png" alt="Github">-->
        <!--                        <span>GitHub</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--                <div class="col">-->
        <!--                    <a class="dropdown-icon-item" href="#">-->
        <!--                        <img src="<?= base_url() ?>partial/images/brands/bitbucket.png" alt="bitbucket">-->
        <!--                        <span>Bitbucket</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--                <div class="col">-->
        <!--                    <a class="dropdown-icon-item" href="#">-->
        <!--                        <img src="<?= base_url() ?>partial/images/brands/dribbble.png" alt="dribbble">-->
        <!--                        <span>Dribbble</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--            </div>-->

        <!--            <div class="row g-0">-->
        <!--                <div class="col">-->
        <!--                    <a class="dropdown-icon-item" href="#">-->
        <!--                        <img src="<?= base_url() ?>partial/images/brands/dropbox.png" alt="dropbox">-->
        <!--                        <span>Dropbox</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--                <div class="col">-->
        <!--                    <a class="dropdown-icon-item" href="#">-->
        <!--                        <img src="<?= base_url() ?>partial/images/brands/mail_chimp.png" alt="mail_chimp">-->
        <!--                        <span>Mail Chimp</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--                <div class="col">-->
        <!--                    <a class="dropdown-icon-item" href="#">-->
        <!--                        <img src="<?= base_url() ?>partial/images/brands/slack.png" alt="slack">-->
        <!--                        <span>Slack</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->


        <?php if (!$this->ion_auth->logged_in()) { ?>
            <div class="dropdown d-inline-block ms-1">
                <a href="<?= site_url('login') ?>" class="btn btn-info mt-3">
                    <i data-feather="log-in" class="icon-lg"></i> Login
                </a>
            </div>
        <?php } else { ?>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?= base_url('partial/images/users/') . $pp->img_name ?>" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?= $pp->first_name ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="<?= site_url('profile') ?>"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock screen </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>