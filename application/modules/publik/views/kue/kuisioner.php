<style>
    .rating-box {
        padding: 0 0 0 12px;
    }
</style>
<div class="row justify-content-center mt-3">
    <div class="col-xl-8 col-lg-10">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm order-2 order-sm-1">
                        <div class="d-flex align-items-end mt-3 mt-sm-0">
                            <div class="flex-shrink-0">
                                <div class="avatar-xl me-3">
                                    <img src="<?= base_url() ?>partial/images/logo/univrab.png" alt="" class="img-fluid rounded d-block">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-24 mb-1">Universitas Abdurrab</h5>
                                    <p class="text-muted font-size-16">FORMULIR KEPUASAN MITRA KERJA SAMA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto order-1 order-sm-2 border-start">
                        <table style="height: 100%;">
                            <tr>
                                <td width="100px">Kode</td>
                                <td>:</td>
                                <td>FM 01 UNIVRAB</td>
                            </tr>
                            <tr>
                                <td>Revisi</td>
                                <td>:</td>
                                <td>01</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end card -->
        <div class="card mt-3">
            <?= form_open('publik/save_answer', array('id' => 'formTanggapan')) ?>
            <div class="card-body">
                <p class="text-center fw-bold fs-5"><?= strtoupper($survey->judul) ?></p>
                <p class="text-center fw-bold fs-5">Universitas Abdurrab</p>

                <input type="hidden" name="survey_id" value="<?= $survey->id ?>">
                <?php
                $no = 1;
                foreach ($pertanyaan as $row) : ?>
                    <div class="mb-3 border-start border-5 border-info rounded shadow-sm bg-white p-3">
                        <p><?= $row->type == 'desc' ? $row->pertanyaan : $no++ . '. ' . $row->pertanyaan ?></p>
                        <input type="hidden" name="qid[]" value="<?= $row->id ?>">
                        <input type="hidden" name="type[<?= $row->id ?>]" value="<?= $row->type ?>">
                        <?php
                        if ($row->type == 'radio_opt') :
                            foreach (json_decode($row->frm_option) as $k => $v) :
                        ?>
                                <div class="form-group">
                                    <input type="radio" id="option_<?= $k ?>" name="answer[<?= $row->id ?>]" value="<?= $k ?>">
                                    <label for="option_<?= $k ?>"><?= $v ?></label>
                                </div>
                            <?php endforeach;
                            echo '<span class="feedback text-danger" id="answer' . $row->id . '"></span>';

                        elseif ($row->type == 'check_opt') :

                            foreach (json_decode($row->frm_option) as $k => $v) :
                            ?>
                                <div class="form-check">
                                    <input type="checkbox" id="option_<?= $k ?>" name="answer[<?= $row->id ?>][]" value="<?= $k ?>">
                                    <label for="option_<?= $k ?>"><?= $v ?></label>
                                </div>
                            <?php endforeach;
                            echo '<span class="feedback text-danger" id="answer' . $row->id . '"></span>';

                        elseif ($row->type == 'textfield_s') : ?>
                            <div class="form-group">
                                <textarea name="answer[<?= $row->id ?>]" id="" cols="30" rows="3" class="form-control" placeholder="Write Something Here..."></textarea>
                            </div>
                        <?php
                            echo '<span class="feedback text-danger" id="answer' . $row->id . '"></span>';
                        elseif ($row->type == 'level_s') : ?>
                            <div class="form-group">
                                <div class="icheck-primary d-inline rating-box">
                                    <input type="radio" id="r1<?= $row->id ?>" name="answer[<?= $row->id ?>]" value="1">
                                    <label for="r1<?= $row->id ?>">1</label>
                                </div>
                                <div class="icheck-primary d-inline rating-box">
                                    <input type="radio" id="r2<?= $row->id ?>" name="answer[<?= $row->id ?>]" value="2">
                                    <label for="r2<?= $row->id ?>">2</label>
                                </div>
                                <div class="icheck-primary d-inline rating-box">
                                    <input type="radio" id="r3<?= $row->id ?>" name="answer[<?= $row->id ?>]" value="3">
                                    <label for="r3<?= $row->id ?>">3</label>
                                </div>
                                <div class="icheck-primary d-inline rating-box">
                                    <input type="radio" id="r4<?= $row->id ?>" name="answer[<?= $row->id ?>]" value="4">
                                    <label for="r4<?= $row->id ?>">4</label>
                                </div>
                            </div>
                        <?php
                            echo '<span class="feedback text-danger" id="answer' . $row->id . '"></span>';
                        endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- end of card body -->
            <div class="card-footer">
                <button type="button" class="btn btn-primary" id="simpan">Submit</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>