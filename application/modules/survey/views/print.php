<div class="card card-outline card-success">
    <div class="card-header">
        <span class="card-title h4"><b>Pernyataan Kuisioner</b></span>
    </div>
    <div class="card-body">
        <?php foreach ($pertanyaan as $row) : ?>
            <div class="panel mb-3 border-start border-5 border-info rounded shadow-sm bg-white">
                <div class="row px-4 pt-2">
                    <div class="col-sm">
                        <h6><?= $row['pertanyaan'] ?></h6>
                    </div>
                </div>
                <div class="row px-4 pb-3">
                    <div class="col-12 border-top pt-3">
                        <input type="hidden" name="qid[<?= $row['id'] ?>]" value="<?= $row['id'] ?>">
                        <input type="hidden" name="type[<?= $row['id'] ?>]" value="<?= $row['type'] ?>">
                        <?php if (in_array($row['type'], $two_type)) : ?>
                            <ul>
                                <?php foreach (json_decode($row['frm_option']) as $k => $v) :
                                    $prog = ((isset($jawaban[$row['id']][$k]) ? count($jawaban[$row['id']][$k]) : 0) / $taken) * 100;
                                    $prog = round($prog, 2);
                                ?>
                                    <li>
                                        <div class="d-block w-100">
                                            <b><?php echo $v ?></b>
                                        </div>
                                        <div class="d-flex w-100">
                                            <span class=""><?php echo isset($jawaban[$row['id']][$k]) ? count($jawaban[$row['id']][$k]) : 0 ?>/<?php echo $taken ?></span>
                                            <div class="mx-1 col-sm-8">
                                                <div class="progress w-100">
                                                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                                                        <span class="sr-only"><?php echo $prog ?>%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="badge badge-info"><?php echo $prog ?>%</span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <div class="d-block tfield-area w-100">
                                <?php if (isset($jawaban[$row['id']])) : ?>
                                    <?php foreach ($jawaban[$row['id']] as $val) : ?>
                                        <blockquote class="blockquote font-size-14 mb-2">
                                            <p><?php echo $val ?></p>
                                        </blockquote>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- end card -->