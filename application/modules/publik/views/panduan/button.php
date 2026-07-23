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
                        <a class="nav-link <?= $aktif == 'table' ? 'active' : '' ?>" href="<?= site_url('publik/panduan/table') ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="List" data-type="table">
                            <i class="bx bx-list-ul"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $aktif == 'grid' ? 'active' : '' ?>" href="<?= site_url('publik/panduan/grid') ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Grid" data-type="grid">
                            <i class="bx bx-grid-alt"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
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