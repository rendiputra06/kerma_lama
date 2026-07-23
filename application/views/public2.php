<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $this->template->title->default("Default title"); ?> | <?= $this->config->item('system_title'); ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $this->template->description; ?>">
    <meta name="author" content="">
    <?php echo $this->template->meta; ?>

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>partial/images/favicon.ico">
    <link href="<?= base_url() ?>partial/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- preloader css -->
    <link rel="stylesheet" href="<?= base_url() ?>partial/css/preloader.min.css" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>partial/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>partial/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>partial/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>partial/libs/sweetalert2/sweetalert2.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <?php echo $this->template->stylesheet; ?>

</head>

<body data-topbar="light" data-layout="horizontal">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="container-fluid">
                <?= $this->template->content; ?>
            </div> <!-- container-fluid -->
            <div class="page-content">
            </div>
            <!-- End Page-content -->
            <footer class="footer">
                <?= $this->template->widget("public_footer"); ?>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>partial/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>partial/libs/jquery/jquery.cookie.min.js"></script>
    <script src="<?= base_url() ?>partial/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>partial/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- App js -->
    <!-- <script src="<?= base_url() ?>partial/js/app.js"></script> -->
    <script src="<?= base_url() ?>partial/js/index.js"></script>
    <script>
        site = "<?= site_url() ?>"
        base = "<?= base_url() ?>"

        var csrfname = '<?= $this->security->get_csrf_token_name() ?>';

        function ajaxcsrf() {
            var csrf = {};
            csrf[csrfname] = $.cookie('csrf_cookie_name');
            $.ajaxSetup({
                "data": csrf
            });
        }
    </script>
    <?php echo $this->template->javascript; ?>

</body>

</html>