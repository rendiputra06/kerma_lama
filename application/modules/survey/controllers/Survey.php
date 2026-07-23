<?php defined('BASEPATH') or exit('No direct script access allowed');

class Survey extends MY_Controller
{
    private $user;
    private $tables;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user = $this->ion_auth->user()->row();
        $this->form_validation->CI = &$this;
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->load->model('Survey_model', 'survey');
        $this->load->library('datatables'); // Load Library Ignited-Datatables
        $this->tables = $this->config->item('tables', 'ion_auth');
    }
    public function index()
    {
        $this->is_allowed();
        $this->_assets_table();
        $this->template->title = 'Kuisioner';
        $this->breadcrumbs->push('Kuisioner', '/survey');
        $this->template->javascript->add('partial/js/kerma/survey/data.js');
        $data['user'] = $this->user;
        $this->template->content->view('index', $data);
        $this->template->publish();
    }
    public function data($id = null)
    {
        $this->ajax_only();
        $this->_json($this->survey->get_data(), false);
    }
    public function save_survey()
    {
        $this->ajax_only();
        $mode = $this->input->post('mode', true);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('kode', 'Kode', 'trim|required');
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'trim|required');
        $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
        $data = [];
        if ($this->form_validation->run() == FALSE) {
            $errors = array(
                'kode'            => form_error('kode'),
                'judul'           => form_error('judul'),
                'deskripsi'       => form_error('deskripsi'),
                'tanggal_mulai'   => form_error('tanggal_mulai'),
                'tanggal_selesai' => form_error('tanggal_selesai'),
            );
            $data = ['status' => FALSE, 'errors' => $errors];
        } else {
            if ($mode == 'add') {
                $data = $this->survey->insert_survey();
            } else {
                $data = $this->survey->update_survey();
            }
        }
        $this->_json($data);
    }
    public function editSurvey()
    {
        $this->ajax_only();
        $this->_json($this->survey->get_survey($this->input->post('id'))->row());
    }
    public function hapusSurvey()
    {
        $this->ajax_only();
        $this->db->delete('kerma_survey', ['id' => $this->input->post('id')]);
        $this->_json(['status' => TRUE]);
    }
    // ================================
    // Controller untuk Halaman Detail
    // ================================
    public function detail($id)
    {
        $this->is_allowed();
        $this->_assets_table();
        $this->template->title = 'Detail Kuisioner';
        $this->breadcrumbs->push('Kuisioner', '/survey');
        $this->breadcrumbs->push('Detail', '/survey/detail/' . $id);
        $this->template->stylesheet->add('partial/libs/alertifyjs/build/css/alertify.min.css');
        $this->template->javascript->add('partial/libs/alertifyjs/build/alertify.min.js');
        $this->template->javascript->add('partial/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js');
        $this->template->javascript->add('partial/js/kerma/survey/detail.js');
        $data['survey'] = $this->survey->get_survey($id)->row();
        $data['pertanyaan'] = $this->survey->get_pertanyaan_sid($id)->result();
        $this->template->content->view('detail', $data);
        $this->template->publish();
    }
    public function save_pertanyaan()
    {
        $this->ajax_only();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'trim|required');
        $this->form_validation->set_rules('type', 'Tipe', 'trim|required');
        $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
        $data = [];
        if ($this->form_validation->run() == FALSE) {
            $errors = array(
                'pertanyaan' => form_error('pertanyaan'),
                'type'       => form_error('type'),
            );
            $data = ['status' => FALSE, 'errors' => $errors];
        } else {
            $type       = $this->input->post('type');
            $label      = $this->input->post('label');
            // $frm_option = $type != 'textfield_s' ? generate_option($label) : '';
            $frm_option = '';
            $not_in = ['textfield_s', 'level_s', 'desc'];
            if (!in_array($type, $not_in)) {
                $frm_option = generate_option($label);
            }
            $send = [
                'survey_id'     => $this->input->post('survey_id'),
                'pertanyaan'    => $this->input->post('pertanyaan'),
                'type'          => $type,
                'frm_option'    => $frm_option,
            ];
            if ($this->input->post('mode', true) == 'add') {
                $send['order_by'] = $this->survey->get_order($this->input->post('survey_id'));
                $data = $this->survey->insert_pertanyaan($send);
            } else {
                $data = $this->survey->update_pertanyaan($send);
            }
        }
        $this->_json($data);
    }
    public function editPertanyaan()
    {
        $this->ajax_only();
        $this->_json($this->survey->get_pertanyaan($this->input->post('id'))->row());
    }
    public function hapusPertanyaan()
    {
        $this->ajax_only();
        $this->db->delete('kerma_pertanyaan', ['id' => $this->input->post('id')]);
        $this->_json(['status' => TRUE]);
    }
    public function update_qsort()
    {
        $this->ajax_only();
        $qid = $this->input->post('qid');
        $update = array();
        $i = 1;
        foreach ($qid as $key => $value) {
            $update[] = ['id' => $value, 'order_by' => $i++];
        }
        $this->db->update_batch('kerma_pertanyaan', $update, 'id');
        $this->_json(['status' => TRUE, 'update' => $update]);
    }
    public function data_tanggapan($token)
    {
        $this->ajax_only();
        $this->_json($this->survey->data_tanggapan($token), false);
    }
    public function tanggapan($id)
    {
        $this->is_allowed();
        $this->_assets_table();
        $this->template->title = 'Tanggapan Kuisioner';
        $this->breadcrumbs->push('Kuisioner', '/survey');
        $this->breadcrumbs->push('Detail', '/survey/detail/' . $id);
        $this->breadcrumbs->push('Tanggapan', '/survey/tanggapan/' . $id);
        $this->template->javascript->add('partial/js/kerma/survey/tanggapan.js');
        $data['survey'] = $this->survey->get_survey($id)->row();
        $data['pertanyaan'] = $this->survey->get_pertanyaan_sid($id)->result_array();
        $data['jawaban'] = $this->survey->get_jawaban($id);
        $data['taken'] = $this->db->get_where('kerma_tanggapan', ['survey_id' => $id])->num_rows();
        $data['two_type'] = ['radio_opt', 'check_opt', 'level_s'];
        $this->template->content->view('tanggapan', $data);
        $this->template->publish();
    }
    public function ajax_publis()
    {
        $this->ajax_only();
        $id = $this->input->post('id');
        $mode = $this->input->post('mode');
        if ($mode == 'edit') {
            $this->db->set('status', '0');
        } else {
            $this->db->set('status', '1');
        }
        $this->db->where('id', $id);
        $this->db->update('kerma_survey');
        $this->_json(['status' => TRUE, 'id' => $id]);
    }
    public function print_page($id)
    {
        $this->is_allowed();
        $this->template->title = 'Print Tanggapan Kuisioner';
        $data['survey'] = $this->survey->get_survey($id)->row();
        $data['pertanyaan'] = $this->survey->get_pertanyaan_sid($id)->result_array();
        $data['jawaban'] = $this->survey->get_jawaban($id);
        $data['taken'] = $this->db->get_where('kerma_tanggapan', ['survey_id' => $id])->num_rows();
        $data['two_type'] = ['radio_opt', 'check_opt', 'level_s'];
        $this->template->content->view('print', $data);
        $this->template->publish('public2');
    }
}
