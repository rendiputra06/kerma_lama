<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Publik extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('publik_model', 'publik');
        $this->load->library('datatables');
    }
    public function index()
    {
        $this->template->title = 'Beranda';
        $this->_assets_table();
        $this->template->stylesheet->add('partial/libs/chart.js/Chart.min.css');
        $this->template->javascript->add('partial/libs/chart.js/Chart.min.js');
        $this->template->javascript->add('partial/js/publik/index.js?v=0.0.1');
        
        $data['tipe_summary'] = $this->publik->get_summary_tipe();
        $data['total_stats']  = $this->publik->get_total_stats();

        $this->template->content->view('index', $data);
        $this->template->publish('public');
    }
    public function jenis_data()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('beranda/Beranda_model', 'beranda');
            $this->_json($this->beranda->getJenisData(), false);
        }
    }
    public function get_chart()
    {
        $this->ajax_only();
        $data = $this->publik->get_chart();
        $this->_json($data);
    }
    public function get_summary_tipe()
    {
        $this->ajax_only();
        $data = $this->publik->get_summary_tipe();
        $this->_json($data);
    }
    public function panduan($mode = '')
    {
        $this->template->title = 'Data Panduan';
        $this->_assets_table();
        $this->breadcrumbs->push('Panduan', '/panduan');
        if ($mode == 'table') {
            $this->_assets_table(TRUE);
            $this->template->content->view('panduan/panduan.php');
        } else {
            $data['panduan'] = $this->publik->get_Panduan()->result();
            $this->template->content->view('panduan/grid', $data);
        }
        $this->template->javascript->add('partial/libs/apexcharts/apexcharts.min.js');
        $this->template->javascript->add('partial/js/publik/panduan.js');
        $this->template->publish('public');
    }
    public function panduan_data()
    {
        $this->ajax_only();
        $this->_json($this->publik->getPanduanData());
    }
    public function kerma()
    {
        $this->template->title = 'Data Kerja Sama';
        $this->_assets_table();
        $this->breadcrumbs->push('Kerja Sama', '/publik/kerja_sama');
        $this->template->javascript->add('partial/libs/apexcharts/apexcharts.min.js');
        $this->template->javascript->add('partial/js/publik/kerma.js?v=0.0.2');
        $this->template->content->view('kerja_sama');
        $this->template->publish('public');
    }
    public function data_kerma()
    {
        $this->ajax_only();
        $this->_json($this->publik->getDataKerma(), false);
    }
    public function laporan()
    {
        $this->template->title = 'Data Laporan';
        $this->_assets_table();
        $this->template->javascript->add('partial/libs/apexcharts/apexcharts.min.js');
        $this->template->javascript->add('partial/js/publik/laporan.js');
        $this->template->content->view('laporan');
        $this->template->publish('public');
    }
    public function data_penerapan()
    {
        $this->ajax_only();
        $this->_json($this->publik->getDataPenerapan(), false);
    }
    // ====================================
    // Controller untuk Pengisian Kuisioner
    // ====================================
    public function kuesioner_gform()
    {
        redirect('https://docs.google.com/forms/d/e/1FAIpQLSfpLztb1gOt6bebq4RO4jGmnij-bmrxzFcETXxDWQ2OIa6Vbw/viewform');
    }

    public function kuisioner($token)
    {
        $this->template->title = 'Kuisioner';
        // $this->_assets_table();
        $this->template->javascript->add('partial/js/publik/kuesioner.js');
        $survey = $this->publik->get_survey($token);
        if ($survey && $survey->status == '1') {
            if (!isset($_SESSION['data_peserta'])) {
                $this->template->content->view('kue/peserta');
            } else {
                $data['survey']     = $survey;
                $data['pertanyaan'] = $this->publik->get_pertanyaan($survey->id);
                $this->template->content->view('kue/kuisioner', $data);
            }
        } else {
            $this->template->content->view('not_found');
        }
        $this->template->publish('public2');
    }
    public function save_peserta()
    {
        $this->ajax_only();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        // $email_unique = '|is_unique[kerma_peserta.email]';
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('nama_instansi', 'Nama Instansi', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('bidang', 'Bidang', 'trim|required');
        $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
        $this->form_validation->set_message('valid_email', 'Harap %s gunakan email yang valid');
        $this->form_validation->set_message('is_unique', '{field} ini sudah dipakai, silahkan ganti');
        if ($this->form_validation->run() == FALSE) {
            $errors = array(
                'nama'          => form_error('nama'),
                'email'         => form_error('email'),
                'nama_instansi' => form_error('nama_instansi'),
                'alamat'        => form_error('alamat'),
                'bidang'        => form_error('bidang'),
            );
            $data = ['status' => FALSE, 'errors' => $errors];
        } else {
            // masukkan kedalam session
            $this->session->set_userdata(['data_peserta' => $_POST]);
            $data = ['status' => TRUE, 'post' => $_POST];
        }
        $this->_json($data);
    }
    public function save_answer()
    {
        $this->ajax_only();
        $qid        = $this->input->post('qid');
        $type       = $this->input->post('type');
        $this->form_validation->set_error_delimiters('', '');
        // buat dulu rules berdasarkan data yang didapat dari question id
        foreach ($this->input->post('qid') as $id) {
            // buat validasi jika type pertanyaan tidak deskripsi
            if ($type[$id] != 'desc') {
                $this->form_validation->set_rules('answer[' . $id . ']', 'Pertanyaan', 'trim|required');
            }
        }
        $this->form_validation->set_message('required', '%s ini masih kosong, silahkan diisi!');
        if ($this->form_validation->run() == FALSE) {
            $err = $this->form_validation->get_error_array();
            $data = ['status' => FALSE, 'errors' => $err];
        } else {
            $answer     = $this->input->post('answer');
            $survey_id  = $this->input->post('survey_id');
            // insert data peserta terlebih dahulu
            $ses_peserta = $this->session->userdata('data_peserta');
            // siapkan data tanggapan
            $tanggapan = array(
                'survey_id' => $survey_id,
                'user_id'   => $this->session->userdata('user_id'),
                'nama'      => $ses_peserta['nama'],
                'email'     => $ses_peserta['email'],
                'nama_instansi' => $ses_peserta['nama_instansi'],
                'alamat'    => $ses_peserta['alamat'],
                'bidang'    => $ses_peserta['bidang'],
                'group_id'  => '0',
                'jumlah_tanggapan' => count($answer)
            );
            $this->db->insert('kerma_tanggapan', $tanggapan);
            $tanggapan_id = $this->db->insert_id();
            foreach ($qid as $k => $v) {

                if ($type[$v] == 'check_opt') {
                    $send['jawaban'] =  implode("],[", $answer[$v]);
                } else if ($type[$v] == 'desc') {
                    continue;
                } else {
                    $send['jawaban'] = $answer[$v];
                }
                $send['tanggapan_id'] = $tanggapan_id;
                $send['pertanyaan_id'] = $qid[$k];
                $save[] = $send;
            }
            $this->db->insert_batch('kerma_isi_tanggapan', $save);
            // var_dump($save);
            // setelah semua data disimpan, hapus session
            $this->session->unset_userdata('data_peserta');
            $data = ['status' => TRUE];
        }
        $this->_json($data);

        // $this->_json(['status' => TRUE]);
    }
    public function cari_unit_select2()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('kerja_sama/Kerma_model', 'kerma');
            $result = $this->kerma->get_unit_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nm_unit];
            }
            echo json_encode($json);
        }
    }
    public function cari_tipe_select2()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('kerja_sama/Kerma_model', 'kerma');
            $result = $this->kerma->get_tipe_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nama_tipe];
            }
            echo json_encode($json);
        }
    }
    public function cari_jenis_select2()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('kerja_sama/Kerma_model', 'kerma');
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
            $this->load->model('kerja_sama/Kerma_model', 'kerma');
            $result = $this->kerma->get_kategori_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nama];
            }
            echo json_encode($json);
        }
    }
}
