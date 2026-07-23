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
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Identitas Peserta</h4>
            </div>
            <div class="card-body p-4">

                <div class="row">
                    <div>
                        <?= form_open('publik/save_peserta', array('id' => 'pesertaForm')) ?>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_instansi">Nama Instansi</label>
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                            <span class="invalid-feedback"></span>
                        </div>

                        <div>
                            <h5 class="font-size-14 mb-4">Kerja Sama Bidang</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bidang" value="pendidikan" id="formRadios1">
                                <label class="form-check-label" for="formRadios1">
                                    Pendidikan (PBL/PKL/KKN/Seminar/ Kuliah Umum)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bidang" value="penelitian" id="formRadios2">
                                <label class="form-check-label" for="formRadios2">
                                    Penelitian
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bidang" value="pengabdian" id="formRadios3">
                                <label class="form-check-label" for="formRadios3">
                                    Pengabdian
                                </label>
                            </div>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mt-4">
                            <button type="buttom" class="btn btn-primary w-md float-end" id="savePeserta">Lanjut</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>