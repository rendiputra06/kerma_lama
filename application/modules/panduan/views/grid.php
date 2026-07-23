<?= $this->load->view('button', ['aktif' => 'grid']); ?>

<div class="row">
    <?php foreach ($panduan as $row) : ?>
        <div class="col-xl-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="dropdown text-end">
                        <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Download</a>
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Hapus</a>
                        </div>
                    </div>

                    <div class="mx-auto mb-4">
                        <img src="<?= base_url('uploads/panduan/') . $row->cover ?>" alt="" class="img-thumbnail">
                    </div>
                    <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?= $row->judul ?></a></h5>
                    <p class="text-muted mb-2"><?= $row->deskripsi ?></p>

                </div>

                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-light text-truncate"><i class="uil uil-user me-1"></i> Detail</button>
                    <button type="button" class="btn btn-outline-light text-truncate"><i class="uil uil-envelope-alt me-1"></i> Download</button>

                </div>
            </div>
            <!-- end card -->
        </div>
    <?php endforeach; ?>
    <!-- end col -->
</div>
<!-- end row -->