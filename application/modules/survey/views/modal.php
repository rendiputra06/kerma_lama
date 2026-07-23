<div id="myModal" class="modal fade" tabindex="-1" data-bs-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('survey/save_pertanyaan', array('id' => 'manageForm'), array('mode' => 'add', 'id' => '', 'survey_id' => $survey->id)) ?>
                <div class="mb-3">
                    <label for="" class="control-label">Judul / Deskripsi</label>
                    <textarea id="pertanyaan" name="pertanyaan" id="" cols="30" rows="4" class="form-control"></textarea>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="type" class="control-label">Tipe Pertanyaan</label>
                    <select name="type" id="type" class="form-control">
                        <option value="empty" selected>Pilih Tipe Pertanyaan</option>
                        <option value="radio_opt">Single Answer/Radio Button</option>
                        <option value="check_opt">Multiple Answer/Check Boxes</option>
                        <option value="textfield_s">Text Field/ Text Area</option>
                        <option value="level_s">Level / Rating</option>
                        <option value="desc">Description</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <b>Preview : </b>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="preview">
                            <p class="float-center">
                                <i>Untuk melihat preview, Silahkan dipilih Tipe pertanyaan terlebih dahulu.</i>
                            </p>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light" id="saveBtn">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="opt_clone" style="display: none">
    <div class="callout callout-info">
        <table width="100%" class="table" id="opt_table">
            <colgroup>
                <col width="10%">
                <col width="80%">
                <col width="10%">
            </colgroup>
            <thead>
                <tr class="">
                    <th class="text-center"></th>

                    <th class="text-center">
                        <label for="" class="control-label">Label</label>
                    </th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button class="btn btn-sm btn-flat btn-default" type="button" onclick="new_check($(this))"><i class="fa fa-plus"></i> Add</button>
            </div>
        </div>
    </div>
</div>

<div id="check_opt_clone" style="display: none">
    <div class="callout callout-info">
        <table width="100%" class="table">
            <colgroup>
                <col width="10%">
                <col width="80%">
                <col width="10%">
            </colgroup>
            <thead>
                <tr class="">
                    <th class="text-center"></th>

                    <th class="text-center">
                        <label for="" class="control-label">Label</label>
                    </th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <td class="text-center">
                        <div class="icheck-primary d-inline" data-count='1'>
                            <input type="checkbox" id="checkboxPrimary1" checked="">
                            <label for="checkboxPrimary1">
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <input type="text" class="form-control form-control-sm check_inp" name="label[]">
                    </td>
                    <td class="text-center"></td>
                </tr>
                <tr class="">
                    <td class="text-center">
                        <div class="icheck-primary d-inline" data-count='2'>
                            <input type="checkbox" id="checkboxPrimary2">
                            <label for="checkboxPrimary2">
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <input type="text" class="form-control form-control-sm check_inp" name="label[]">
                    </td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button class="btn btn-sm btn-default" type="button" onclick="new_check($(this))"><i class="fa fa-plus"></i> Add</button>
            </div>
        </div>
    </div>
</div>
<div id="radio_opt_clone" style="display: none">
    <div class="callout callout-info">
        <table width="100%" class="table">
            <colgroup>
                <col width="10%">
                <col width="80%">
                <col width="10%">
            </colgroup>
            <thead>
                <tr class="">
                    <th class="text-center"></th>

                    <th class="text-center">
                        <label for="" class="control-label">Label</label>
                    </th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <td class="text-center">
                        <div class="icheck-primary d-inline" data-count='1'>
                            <input type="radio" id="radioPrimary1" name="radio" checked="">
                            <label for="radioPrimary1">
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <input type="text" class="form-control form-control-sm check_inp" name="label[]">
                    </td>
                    <td class="text-center"></td>
                </tr>
                <tr class="">
                    <td class="text-center">
                        <div class="icheck-primary d-inline" data-count='2'>
                            <input type="radio" id="radioPrimary2" name="radio">
                            <label for="radioPrimary2">
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <input type="text" class="form-control form-control-sm check_inp" name="label[]">
                    </td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button class="btn btn-sm btn-default" type="button" onclick="new_radio($(this))"><i class="fa fa-plus"></i> Add</button>
            </div>
        </div>
    </div>
</div>
<div id="textfield_s_clone" style="display: none">
    <div class="callout callout-info">
        <textarea name="frm_opt" id="" cols="30" rows="6" class="form-control" disabled="" placeholder="Write Something here..."></textarea>
    </div>
</div>
<div id="level_s_clone" style="display: none">
    <div class="callout callout-info text-center">
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
</div>