<?= $this->load->view('button', ['aktif' => 'table']); ?>
<div class="row">
    <div class="col-12">
        <div class="table-responsive" style="border: 0">
            <table id="panduan" class="w-100 table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Terbit</th>
                        <th>Dokumen</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Terbit</th>
                        <th>Dokumen</th>
                        <th class="text-center">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->