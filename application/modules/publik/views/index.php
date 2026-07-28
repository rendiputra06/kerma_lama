<!-- Top KPI Summary Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-primary rounded-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-medium text-uppercase font-size-12">Total Kerja Sama</span>
                        <h3 class="fw-bold mb-0 mt-1 text-primary"><?= number_format($total_stats->total_kerma ?? 0); ?></h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-circle fs-3 p-2">
                            <i class="fa fa-folder-open"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-success rounded-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-medium text-uppercase font-size-12">Kerja Sama Aktif</span>
                        <h3 class="fw-bold mb-0 mt-1 text-success"><?= number_format($total_stats->total_aktif ?? 0); ?></h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-success text-success rounded-circle fs-3 p-2">
                            <i class="fa fa-check-circle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-danger rounded-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-medium text-uppercase font-size-12">Kerja Sama Berakhir</span>
                        <h3 class="fw-bold mb-0 mt-1 text-danger"><?= number_format($total_stats->total_expired ?? 0); ?></h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-danger text-danger rounded-circle fs-3 p-2">
                            <i class="fa fa-clock"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100 border-0 shadow-sm border-start border-4 border-info rounded-3">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-medium text-uppercase font-size-12">Unit Pelaksana</span>
                        <h3 class="fw-bold mb-0 mt-1 text-info"><?= number_format($total_stats->total_unit ?? 0); ?></h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-info text-info rounded-circle fs-3 p-2">
                            <i class="fa fa-university"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section: Tipe Kerja Sama Summary Cards (MoU, MoA, PKS, LOI, IA) -->
<div class="row mb-2">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa fa-layer-group text-primary me-2"></i> Rekapitulasi Berdasarkan Tipe Kerja Sama
            </h5>
            <a href="<?= site_url('publik/kerma') ?>" class="btn btn-sm btn-soft-primary rounded-pill">
                Lihat Detail <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <?php 
    $type_styles = [
        'MoU' => ['border' => 'border-primary', 'badge' => 'bg-primary', 'text' => 'text-primary', 'bg_soft' => 'bg-soft-primary', 'icon' => 'fa-file-contract'],
        'MoA' => ['border' => 'border-info', 'badge' => 'bg-info', 'text' => 'text-info', 'bg_soft' => 'bg-soft-info', 'icon' => 'fa-handshake'],
        'PKS' => ['border' => 'border-success', 'badge' => 'bg-success', 'text' => 'text-success', 'bg_soft' => 'bg-soft-success', 'icon' => 'fa-file-signature'],
        'LOI' => ['border' => 'border-warning', 'badge' => 'bg-warning', 'text' => 'text-warning', 'bg_soft' => 'bg-soft-warning', 'icon' => 'fa-envelope-open-text'],
        'IA'  => ['border' => 'border-purple', 'badge' => 'bg-purple text-white', 'text' => 'text-purple', 'bg_soft' => 'bg-soft-purple', 'icon' => 'fa-tasks', 'custom_color' => '#6f42c1'],
    ];
    
    if (!empty($tipe_summary)):
        foreach ($tipe_summary as $tipe):
            $name = strtoupper(trim($tipe->nama_tipe));
            $style = $type_styles[$name] ?? ['border' => 'border-secondary', 'badge' => 'bg-secondary', 'text' => 'text-secondary', 'bg_soft' => 'bg-soft-secondary', 'icon' => 'fa-file-alt'];
            $custom_style = isset($style['custom_color']) ? "style='color: {$style['custom_color']} !important;'" : "";
            $custom_badge = isset($style['custom_color']) ? "style='background-color: {$style['custom_color']} !important; color: #fff;'" : "";
    ?>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card h-100 border-0 shadow-sm rounded-3 border-top border-4 <?= $style['border']; ?>" style="transition: transform 0.2s ease-in-out;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge px-2 py-1 <?= $style['badge']; ?>" <?= $custom_badge; ?>><?= html_escape($tipe->nama_tipe); ?></span>
                        <i class="fa <?= $style['icon']; ?> font-size-18" <?= $custom_style; ?>></i>
                    </div>
                    <div class="mt-2">
                        <h3 class="fw-bold mb-1" <?= $custom_style; ?>><?= number_format($tipe->total); ?></h3>
                        <div class="font-size-12 text-muted">Dokumen Cooperation</div>
                    </div>
                    <hr class="my-2 border-light">
                    <div class="d-flex justify-content-between align-items-center font-size-11">
                        <span class="text-success"><i class="fa fa-circle font-size-9 me-1"></i> Aktif: <strong><?= number_format($tipe->total_aktif); ?></strong></span>
                        <span class="text-danger"><i class="fa fa-circle font-size-9 me-1"></i> Berakhir: <strong><?= number_format($tipe->total_expired); ?></strong></span>
                    </div>
                </div>
            </div>
        </div>
    <?php 
        endforeach;
    endif;
    ?>
</div>

<!-- Visualizations & Data Tables -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 font-size-15 fw-bold text-dark">
                    <i class="fa fa-chart-pie text-primary me-2"></i> Kerja Sama Berdasarkan Unit Kerja
                </h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div style="position: relative; width: 100%; height: 320px;">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 font-size-15 fw-bold text-dark">
                    <i class="fa fa-globe text-info me-2"></i> Jumlah Berdasarkan Jenis Kerja Sama
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 320px;" data-simplebar>
                    <table id="jumlah_kerma" class="w-100 table table-striped table-hover table-borderless align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">No.</th>
                                <th>Jenis Kerjasama</th>
                                <th class="text-center" style="width: 25%;">Jumlah Dokumen</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- end row-->