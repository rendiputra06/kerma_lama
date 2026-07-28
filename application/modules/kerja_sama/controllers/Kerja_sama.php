<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kerja_sama extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user = $this->ion_auth->user()->row();
        $this->form_validation->CI = &$this;
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->load->model('Kerma_model', 'kerma');
        $this->load->library('datatables'); // Load Library Ignited-Datatables
    }
    public function index()
    {
        $this->is_allowed();
        $this->_assets_table(TRUE);
        $this->template->title = 'Data Kerja Sama';
        $this->breadcrumbs->push('Universitas', '/kerja_sama/index');
        $this->template->stylesheet->add('partial/libs/select2/css/select2.min.css');
        $this->template->stylesheet->add('partial/libs/dropify/css/dropify.min.css');
        $this->template->javascript->add('partial/libs/select2/js/select2.full.min.js');
        $this->template->javascript->add('partial/libs/dropify/js/dropify.min.js');
        $this->template->javascript->add('partial/libs/jquery-file/jquery.fileDownload.js');
        $this->template->javascript->add('partial/js/kerma/kerja_sama.js?v=0.1.5');
        $data['prodi'] = null;
        if ($this->ion_auth->in_group('prodi')) {
            $data['prodi'] = $this->kerma->get_user_prodi($this->user->id_tendik);
        }
        $this->template->content->view('index', $data);
        $this->template->publish();
    }
    public function data_kerma($id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->_json($this->kerma->getDataKerma($id), false);
        }
    }
    public function save()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
            $this->form_validation->set_rules('mitra', 'Mitra', 'trim|required');
            $this->form_validation->set_rules('unit_id', 'Unit Pelaksana', 'trim|required');
            $this->form_validation->set_rules('jenis_id', 'Jenis Kerja Sama', 'trim|required');
            //$this->form_validation->set_rules('kategori_id', 'Jenis Kerja Sama', 'trim|required');
            $this->form_validation->set_rules('bentuk_id', 'Jenis Kerja Sama', 'trim|required');
            $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'trim|required');
            $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'trim|required');
            $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'judul'             => form_error('judul'),
                    'mitra'             => form_error('mitra'),
                    'unit_id'           => form_error('unit_id'),
                    'jenis_id'          => form_error('jenis_id'),
                    'kategori_id'       => form_error('kategori_id'),
                    'bentuk_id'         => form_error('bentuk_id'),
                    'tanggal_mulai'     => form_error('tanggal_mulai'),
                    'tanggal_selesai'   => form_error('tanggal_selesai'),
                );
                $data = ['status' => FALSE, 'errors' => $errors];
            } else {
                $upload_error = null;
                $dokumen = '';
                $has_file = (isset($_FILES['dokumen']['name']) && $_FILES['dokumen']['name'] != '');

                if ($mode == 'add') {
                    if ($has_file) {
                        $upload = $this->_upload_dokumen();
                        if ($upload['status'] === FALSE) {
                            $upload_error = $upload['msg'];
                        } else {
                            $dokumen = $upload['file_name'];
                        }
                    }
                    if ($upload_error === null) {
                        $data = $this->kerma->insert_data($dokumen);
                    } else {
                        $data = ['status' => FALSE, 'errors' => ['dokumen' => $upload_error]];
                    }
                } else {
                    $id = $this->input->post('id');
                    $old_kerma = $this->kerma->get_kerma($id)->row();
                    if ($has_file) {
                        $upload = $this->_upload_dokumen();
                        if ($upload['status'] === FALSE) {
                            $upload_error = $upload['msg'];
                        } else {
                            // hapus file yang lama
                            if (file_exists('uploads/kerma/' . $old_kerma->dokumen) && $old_kerma->dokumen) {
                                unlink('uploads/kerma/' . $old_kerma->dokumen);
                            }
                            $dokumen = $upload['file_name'];
                        }
                    } else {
                        $dokumen = $old_kerma->dokumen;
                    }
                    if ($upload_error === null) {
                        $data = $this->kerma->update_data($dokumen);
                    } else {
                        $data = ['status' => FALSE, 'errors' => ['dokumen' => $upload_error]];
                    }
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    private function _upload_dokumen()
    {
        $config['upload_path'] = 'uploads/kerma'; //path folder
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx|png|jpg|jpeg';
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('dokumen')) //upload and validate
        {
            return array(
                'status' => FALSE,
                'msg' => $this->upload->display_errors('', '')
            );
        }
        return array(
            'status' => TRUE,
            'file_name' => $this->upload->data('file_name')
        );
    }
    public function editAjax()
    {
        if ($this->input->is_ajax_request()) {
            $this->_json($this->kerma->editAjax());
        }
    }
    public function hapusAjax()
    {
        $this->ajax_only();
        $id = $this->input->post('id');
        $kerma = $this->kerma->get_kerma($id)->row();
        if (file_exists('uploads/kerma/' . $kerma->dokumen) && $kerma->dokumen) {
            unlink('uploads/kerma/' . $kerma->dokumen);
        }
        $this->db->delete('kerma', ['id' => $id]);
        $this->_json(['status' => TRUE]);
    }
    public function cari_unit_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->kerma->get_unit_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nm_unit];
            }
            echo json_encode($json);
        }
    }
    public function cari_jenis_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->kerma->get_jenis_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nama];
            }
            echo json_encode($json);
        }
    }
    public function cari_kategori_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->kerma->get_kategori_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nama];
            }
            echo json_encode($json);
        }
    }
    public function cari_bentuk_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->kerma->get_bentuk_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nama];
            }
            echo json_encode($json);
        }
    }
    public function cari_tipe_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->kerma->get_tipe_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nama_tipe];
            }
            echo json_encode($json);
        }
    }
    public function export()
    {
        // Ambil data dengan filter sama seperti datatable
        $data = $this->kerma->export();
    
        include_once APPPATH . '/third_party/xlsxwriter.class.php';
        ob_end_clean(); // Pastikan tidak ada output sebelumnya
        mb_internal_encoding("UTF-8");
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        error_reporting(E_ALL & ~E_NOTICE);
    
        $filename = "data-kerja-sama-" . date('d-m-Y-H-i-s') . ".xlsx";
        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Set-Cookie: fileDownload=true; path=/');
        header('Cache-Control: max-age=60, must-revalidate');
    
        // === STYLES (dipertahankan dari versi kamu) ===
        $styles = array(
            'widths' => [5, 40, 80, 50, 15, 15, 30, 20, 20, 20],
            'font' => 'Arial',
            'font-size' => 10,
            'font-style' => 'bold',
            'fill' => '#eee',
            'halign' => 'center',
            'border' => 'left,right,top,bottom'
        );
    
        $styles2 = array(
            ['border' => 'left,right,top,bottom', 'fill' => '#ffc'],
            ['border' => 'left,right,top,bottom', 'fill' => '#fcf'],
            ['border' => 'left,right,top,bottom', 'fill' => '#ccf'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff', 'halign' => 'center'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff', 'halign' => 'center'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff', 'halign' => 'center'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff', 'halign' => 'center'],
            ['border' => 'left,right,top,bottom', 'fill' => '#cff', 'halign' => 'center'],
        );
    
        // === HEADER BARU (gabungan tipe dan jenis) ===
        $header = array(
            'No' => 'integer',
            'Fakultas/Prodi/Bagian' => 'string',
            'Judul' => 'string',
            'Lembaga Mitra Kerjasama' => 'string',
            'Jenis Kerjasama' => 'string',  // Dalam / Luar Negeri
            'Tipe Kerjasama' => 'string',   // MoU / MoA
            'Kategori Mitra' => 'string',   // Kategori Mitra
            'Mulai' => 'string',
            'Berakhir' => 'string',
            'Di Upload' => 'string',
            'Status' => 'string',
        );
    
        // === TULIS KE FILE EXCEL ===
        $writer = new XLSXWriter();
        $writer->setAuthor('KERMA UNIVRAB');
        $writer->writeSheetHeader('Sheet1', $header, $styles);
    
        $no = 1;
        foreach ($data as $row) {
            // Tentukan status otomatis
            $status = $this->getStatusKerma($row->tanggal_mulai, $row->tanggal_selesai, $row->nama_tipe);
    
            $writer->writeSheetRow('Sheet1', [
                $no++,
                $row->nm_unit,
                $row->judul,
                $row->mitra,
                $row->nama_jenis,    // misal: universitas-dalam-negeri → Dalam Negeri
                $row->nama_tipe,
                $row->kategori,
                $row->tanggal_mulai,
                $row->tanggal_selesai,
                $row->create_at,
                $status,
            ], $styles2);
        }
    
        $writer->writeToStdOut();
        exit;
    }
    
    // Helper status untuk kerma
    private function getStatusKerma($mulai, $selesai, $nama_tipe = null)
    {
        // Pengecualian: tipe IA tidak memiliki masa berlaku
        if ($nama_tipe === 'IA') {
            return '-';
        }
        $today = date('Y-m-d');
        if ($selesai < $today) {
            return 'Selesai';
        } elseif ($selesai <= date('Y-m-d', strtotime('+5 months'))) {
            return 'Akan Berakhir';
        } else {
            return 'Aktif';
        }
    }


}
