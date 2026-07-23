<style>
    .panel-placeholder {
        border: 1px dotted black;
        margin: 1em 1em 1em 1em;
        height: 50px;
    }

    .rating-box {
        border: 1px #acb2b5 solid;
        border-radius: 10px;
        margin: 0 10px 0 10px;
        padding: 12px;
    }
</style>
<div class="row">
    <div class="col-xl-4 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-2">Detail Kuisioner</h5>
            </div>
            <div class="card-body">
                <div>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <p>
                                <i class="mdi mdi-web text-primary me-1"></i>
                                <b>Judul</b> : <?= $survey->judul ?>
                            </p>
                        </li>
                        <li>
                            <p>
                                <i class="mdi mdi-note-text-outline text-primary me-1"></i>
                                <b>Deskripsi :</b> <?= $survey->deskripsi; ?>
                            </p>
                        </li>
                        <li>
                            <p>
                                <i class="mdi mdi-note-text-outline text-primary me-1"></i>
                                <b>Tanggal :</b> <?= date("M d, Y", strtotime($survey->tanggal_mulai)) ?> - <?= date("M d, Y", strtotime($survey->tanggal_selesai)) ?>
                            </p>
                        </li>
                        <li>
                            <p>
                                <i class="mdi mdi-note-text-outline text-primary me-1"></i>
                                <b>Status :</b> <?= $survey->status == '0' ? 'Edit' : 'Publis' ?>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="border-top pt-3 text-center">
                    <a class="btn btn-sm btn-warning" target="_black" href="<?= site_url('publik/kuisioner/') . $survey->token ?>"><i class="fa fa-link"></i> Pratinjau</a>
                    <?php if ($survey->status == '0') : ?>
                        <button class="btn btn-sm btn-info statuskue" data-mode="publis" data-id="<?= $survey->id ?>"><i class="fa fa-book"></i> Publis</button>
                    <?php else : ?>
                        <button class="btn btn-sm btn-info statuskue" data-mode="edit" data-id="<?= $survey->id ?>"><i class="fa fa-book"></i> Edit</button>
                    <?php endif; ?>
                </div>
            </div>
            <!-- end card body -->
        </div>

        <div class="card">
            <div class="card-header">
                <span class="card-title h4">Peserta</span>
                <div class="float-end">
                    <a class="btn btn-sm btn-primary" href="<?= site_url('survey/tanggapan/' . $survey->id) ?>"><i class="fa fa-plus"></i> Lihat Tanggapan</a>
                    <button class="btn btn-sm btn-success" type="button" onclick="reload_ajax('table_tanggapan')"><i class="fa fa-sync"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" data-simplebar style="max-height: 300px;">
                    <table class="table table-hover table-sm table-borderless" id="table_tanggapan" data-token="<?= $survey->token ?>">
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card-body -->
        </div>
        <!-- end of card -->
    </div>
    <!-- end col -->
    <div class="col-xl-8 col-lg-6">
        <?= form_open('survey/update_qsort', array('id' => 'manageSort'), array('mode' => 'pengurutan')) ?>
        <div class="card card-outline card-success">
            <div class="card-header">
                <span class="card-title h4"><b>Pernyataan Kuisioner</b></span>
                <div class="float-end">
                    <button class="btn btn-sm btn-primary" id="tambahBtn" type="button" <?= $survey->status == 1 ? 'disabled' : '' ?>><i class="fa fa-plus"></i> Tambah</button>
                    <a class="btn btn-sm btn-success" href="<?= site_url('survey') ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body ui-sortable">
                <?php foreach ($pertanyaan as $row) : ?>
                    <div class="panel mb-3 border-start border-5 border-info rounded shadow-sm bg-white">
                        <div class="row px-4 pt-2">
                            <div class="col-sm">
                                <h6><?= $row->pertanyaan ?></h6>
                            </div>
                            <div class="col-sm-auto">
                                <div class="dropdown float-end">
                                    <a href="#" class="btn btn-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item edit_pertanyaan" href="javascript:void(0)" data-id="<?= $row->id ?>">Edit</a>
                                        <a class="dropdown-item hapus_pertanyaan" href="javascript:void(0)" data-id="<?= $row->id ?>">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row px-4 pb-3">
                            <div class="col-12 border-top pt-3">
                                <input type="hidden" name="qid[]" value="<?= $row->id ?>">
                                <?php
                                if ($row->type == 'radio_opt') :
                                    foreach (json_decode($row->frm_option) as $k => $v) :
                                ?>
                                        <div class="icheck-primary">
                                            <input type="radio" id="option_<?= $k ?>" name="answer[<?= $row->id ?>]" value="<?= $k ?>" checked="">
                                            <label for="option_<?= $k ?>"><?= $v ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php elseif ($row->type == 'check_opt') :
                                    foreach (json_decode($row->frm_option) as $k => $v) :
                                    ?>
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="option_<?= $k ?>" name="answer[<?= $row->id ?>][]" value="<?= $k ?>">
                                            <label for="option_<?= $k ?>"><?= $v ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php elseif ($row->type == 'level_s') : ?>
                                    <div class="form-group mt-2">
                                        <div class="icheck-primary d-inline rating-box" data-count='1'>
                                            <input type="radio" id="radioPrimary1" name="radio">
                                            <label for="radioPrimary1">1</label>
                                        </div>
                                        <div class="icheck-primary d-inline rating-box" data-count='2'>
                                            <input type="radio" id="radioPrimary2" name="radio">
                                            <label for="radioPrimary2">2</label>
                                        </div>
                                        <div class="icheck-primary d-inline rating-box" data-count='3'>
                                            <input type="radio" id="radioPrimary3" name="radio">
                                            <label for="radioPrimary3">3</label>
                                        </div>
                                        <div class="icheck-primary d-inline rating-box" data-count='4'>
                                            <input type="radio" id="radioPrimary4" name="radio">
                                            <label for="radioPrimary4">4</label>
                                        </div>
                                    </div>
                                <?php elseif ($row->type == 'textfield_s') : ?>
                                    <div class="form-group">
                                        <textarea name="answer[<?= $row->id ?>]" id="" cols="30" rows="3" class="form-control" placeholder="Write Something Here..."></textarea>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?= form_close() ?>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<?= $this->load->view('modal'); ?>